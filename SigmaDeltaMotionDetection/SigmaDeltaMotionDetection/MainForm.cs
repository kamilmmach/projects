using System;
using System.Drawing;
using System.Windows.Forms;

namespace SDMD
{
    public partial class MainForm : Form
    {
        public Rectangle captureRect = new Rectangle(0, 60, 200, 200);
        System.Media.SoundPlayer player = new System.Media.SoundPlayer(SDMD.Properties.Resources.alarm);

        public bool isAlarmActive;
        public int gain = 4; // 
        public int tickno = 0; // number of ticks
        public double rmse = 0.0; // Root-mean-square error


        public SigmaDeltaStruct prevCapture;
        public SigmaDeltaStruct currentCapture;
        public DirectBitmap motionEstimator;
        public DirectBitmap bgEstimator;

        private DrawingForm selectionForm = new DrawingForm();

        public MainForm()
        {
            //
            // The InitializeComponent() call is required for Windows Forms designer support.
            //
            InitializeComponent();

            updateCaptureBitmaps();

            selectionForm.VisibleChanged += new System.EventHandler(selectionForm_VisibleChanged);

            lblRuch.Width = pbMotionDetection.Width;

        }

        private void updateCaptureBitmaps()
        {
            if (prevCapture != null)
                prevCapture.Dispose();

            if (currentCapture != null)
                currentCapture.Dispose();

            if (motionEstimator != null)
                motionEstimator.Dispose();

            if (bgEstimator != null)
                bgEstimator.Dispose();

            prevCapture = new SigmaDeltaStruct(captureRect.Width, captureRect.Height);
            currentCapture = new SigmaDeltaStruct(captureRect.Width, captureRect.Height);
            motionEstimator = new DirectBitmap(captureRect.Width, captureRect.Height);
            bgEstimator = new DirectBitmap(captureRect.Width, captureRect.Height);


            using (Graphics g = Graphics.FromImage(currentCapture.BitmapData.Bitmap))
            {
                g.CopyFromScreen(captureRect.X, captureRect.Y,
                    0, 0,
                    currentCapture.BitmapData.Bitmap.Size,
                    CopyPixelOperation.SourceCopy);
            }

            using (Graphics g = Graphics.FromImage(prevCapture.BitmapData.Bitmap))
            {
                g.CopyFromScreen(captureRect.X, captureRect.Y,
                    0, 0,
                    prevCapture.BitmapData.Bitmap.Size,
                    CopyPixelOperation.SourceCopy);
            }

            prevCapture.PopulateEstimators();
            currentCapture.PopulateEstimators();
            bgEstimator.SeedWith8bppGrayscale(currentCapture.FirstBgEstimator);

        }

        private void ToggleAlarm()
        {
            if (isAlarmActive)
            {
                lblCurrentLevel.ForeColor = SystemColors.ControlText;
                player.Stop();
            }
            else
            {
                lblCurrentLevel.ForeColor = System.Drawing.Color.Red;
                player.PlayLooping();
            }
            isAlarmActive = !isAlarmActive;
        }


        private void ToggletmMonitor()
        {
            if (!tmMonitorTick.Enabled)
            {
                updateCaptureBitmaps();
                tmMonitorTick.Start();
                btnStart.Text = "Stop";
                btnSelectRegion.Enabled = false;
            }
            else
            {
                tmMonitorTick.Stop();
                btnStart.Text = "Start";
                btnSelectRegion.Enabled = true;
            }
        }

        private void SigmaDeltaTick()
        {
            int size = currentCapture.BitmapData.Height * currentCapture.BitmapData.Width;

            for (int coord = 0; coord < size; ++coord)
            {

                int currentGray = Utils.getGrayscaleLum(currentCapture.BitmapData.Bits[coord]);
                int prevGray = Utils.getGrayscaleLum(prevCapture.BitmapData.Bits[coord]);

                if (prevCapture.FirstBgEstimator[coord] < currentGray)
                    currentCapture.FirstBgEstimator[coord] = (short)(prevCapture.FirstBgEstimator[coord] + 1);
                else if (prevCapture.FirstBgEstimator[coord] > currentGray)
                    currentCapture.FirstBgEstimator[coord] = (short)(prevCapture.FirstBgEstimator[coord] - 1);
                else
                    currentCapture.FirstBgEstimator[coord] = prevCapture.FirstBgEstimator[coord];

                int delta = Math.Abs(currentCapture.FirstBgEstimator[coord] - currentGray);


                if (prevCapture.SecondBgEstimator[coord] < gain * delta)
                    currentCapture.SecondBgEstimator[coord] = (short)(prevCapture.SecondBgEstimator[coord] + 1);
                else if (prevCapture.SecondBgEstimator[coord] > gain * delta)
                    currentCapture.SecondBgEstimator[coord] = (short)(prevCapture.SecondBgEstimator[coord] - 1);
                else
                    currentCapture.SecondBgEstimator[coord] = prevCapture.SecondBgEstimator[coord];

                Utils.clip(ref currentCapture.SecondBgEstimator[coord], 0, 255);


                if (delta < currentCapture.SecondBgEstimator[coord])
                {
                    motionEstimator.Bits[coord] = unchecked((int)0xff000000);
                }
                else
                {
                    motionEstimator.Bits[coord] = unchecked((int)0xffffffff);
                }
            }

            // Erode and Dilate images to filter out small noise 
            Morphology.ErodeFilter(motionEstimator, 3);
            Morphology.DilateFilter(motionEstimator, 3);

            ulong btar = 0;
            for (int i = 0; i < size; ++i)
            {
                if (motionEstimator.Bits[i] != -1)
                    btar++;
            }
            rmse = btar / (double)size;
            rmse = Math.Sqrt(rmse);

            tickno++;
            tickno %= 256;
        }


        private void btnSelectRegion_Click(object sender, EventArgs e)
        {
            if (!selectionForm.Visible)
                selectionForm.Show();

            tmMonitorTick.Stop();
        }

        private void selectionForm_VisibleChanged(object sender, EventArgs e)
        {
            if (!selectionForm.Visible)
            {
                if (!selectionForm.SelectedRegion.IsEmpty && captureRect != selectionForm.selectedRegion)
                {
                    captureRect = selectionForm.SelectedRegion;
                    updateCaptureBitmaps();
                }
            }
        }

        private void tmMonitorTick_Tick(object sender, EventArgs e)
        {
            prevCapture.Dispose();
            prevCapture = currentCapture;
            currentCapture = new SigmaDeltaStruct(captureRect.Width, captureRect.Height);

            using (Graphics g = Graphics.FromImage(currentCapture.BitmapData.Bitmap))
            {
                g.CopyFromScreen(captureRect.X, captureRect.Y,
                    0, 0,
                    currentCapture.BitmapData.Bitmap.Size,
                    CopyPixelOperation.SourceCopy);
            }
            SigmaDeltaTick();

            pbRegionView.Image = currentCapture.BitmapData.Bitmap;
            pbMotionDetection.Image = motionEstimator.Bitmap;

            lblCurrentLevel.Text = Math.Round(rmse * 100.0).ToString() + "%";

            if (rmse >= (tbAlarmThreshold.Value / 100.0))
            {
                if (!isAlarmActive)
                {
                    ToggleAlarm();
                }
            }
            else
            {
                if (isAlarmActive)
                {
                    ToggleAlarm();
                }
            }

        }

        private void tbGain_ValueChanged(object sender, EventArgs e)
        {
            gain = tbGain.Value;
            lblGain.Text = tbGain.Value.ToString();
        }

        private void tbAlarmThreshold_ValueChanged(object sender, EventArgs e)
        {
            lblAThreshold.Text = tbAlarmThreshold.Value.ToString();
        }

        private void btnStartClick(object sender, EventArgs e)
        {
            ToggletmMonitor();
        }
    }
}
