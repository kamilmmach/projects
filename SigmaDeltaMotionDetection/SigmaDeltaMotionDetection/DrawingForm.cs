using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace SDMD
{
    class DrawingForm : Form
    {
        private bool isSelectingRegion = false;
        public Rectangle SelectedRegion { get { return selectedRegion; } set { selectedRegion = value; } }
        public Rectangle selectedRegion;

        private Point startingPoint = new Point(0, 0);

        private Color backColor = System.Drawing.Color.LightGreen;
        private Pen borderPen = new Pen(Color.Red, 2.0f);

        private Form clickableForm;

        public DrawingForm()
        {
            InitializeComponent();

            selectedRegion = new Rectangle(0, 0, 0, 0);

            ClientSize = SystemInformation.VirtualScreen.Size;
            Location = SystemInformation.VirtualScreen.Location;

            DoubleBuffered = true;

            BackColor = backColor;
            TransparencyKey = backColor;

            clickableForm = new Form();
            clickableForm.ClientSize = ClientSize;
            clickableForm.FormBorderStyle = FormBorderStyle;
            clickableForm.BackColor = Color.Black;
            clickableForm.Opacity = 0.4;
            clickableForm.ShowInTaskbar = false;

            clickableForm.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.DrawingForm_KeyPress);
            clickableForm.MouseDown += new System.Windows.Forms.MouseEventHandler(this.DrawingForm_MouseDown);
            clickableForm.MouseMove += new System.Windows.Forms.MouseEventHandler(this.DrawingForm_MouseMove);
            clickableForm.MouseUp += new System.Windows.Forms.MouseEventHandler(this.DrawingForm_MouseUp);
        }

        private void InitializeComponent()
        {
            this.SuspendLayout();
            // 
            // DrawingForm
            // 
            this.BackColor = System.Drawing.Color.LightGreen;
            this.ClientSize = new System.Drawing.Size(1920, 1080);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "DrawingForm";
            this.ShowInTaskbar = false;
            this.StartPosition = System.Windows.Forms.FormStartPosition.Manual;
            this.TopMost = true;
            this.VisibleChanged += new System.EventHandler(this.DrawingForm_VisibleChanged);
            this.Paint += new System.Windows.Forms.PaintEventHandler(this.DrawingForm_Paint);
            this.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.DrawingForm_KeyPress);
            this.ResumeLayout(false);

        }

        private void DrawingForm_MouseDown(object sender, MouseEventArgs e)
        {
            if (e.Button == MouseButtons.Right)
                Hide();

            if (e.Button == MouseButtons.Left)
            {
                isSelectingRegion = true;
                startingPoint = e.Location;
            }
        }

        private void DrawingForm_MouseUp(object sender, MouseEventArgs e)
        {
            if (isSelectingRegion && e.Button == MouseButtons.Left)
            { 
                isSelectingRegion = false;
                Hide();
            }
        }

        private void DrawingForm_Paint(object sender, PaintEventArgs e)
        {
            e.Graphics.DrawRectangle(borderPen, selectedRegion);
        }

        private void DrawingForm_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)Keys.Escape)
                Hide();
        }

        private void DrawingForm_MouseMove(object sender, MouseEventArgs e)
        {
            if (isSelectingRegion)
            {
                if(e.X < startingPoint.X)
                    selectedRegion.X = e.X;
                else
                    selectedRegion.X = startingPoint.X;

                if (e.Y < startingPoint.Y)
                    selectedRegion.Y = e.Y;
                else
                    selectedRegion.Y = startingPoint.Y;

                selectedRegion.Width = Math.Abs(startingPoint.X - e.X);
                selectedRegion.Height = Math.Abs(startingPoint.Y - e.Y);
                Invalidate();
            }
        }

        private void DrawingForm_VisibleChanged(object sender, EventArgs e)
        {
            clickableForm.Visible = Visible;
            if (Visible)
            {
                selectedRegion.X = 0; selectedRegion.Y = 0; selectedRegion.Width = 0; selectedRegion.Height = 0;
                Invalidate();
            }
        }
    }
}
