/*
 * Created by SharpDevelop.
 * User: Operator
 * Date: 2017-05-28
 * Time: 16:13
 * 
 * To change this template use Tools | Options | Coding | Edit Standard Headers.
 */
namespace SDMD
{
	partial class MainForm
	{
		/// <summary>
		/// Designer variable used to keep track of non-visual components.
		/// </summary>
		private System.ComponentModel.IContainer components = null;
		private System.Windows.Forms.Button btnStart;
		private System.Windows.Forms.PictureBox pbRegionView;
		private System.Windows.Forms.PictureBox pbMotionDetection;
		private System.Windows.Forms.Label lblCurrentLevel;
		private System.Windows.Forms.Timer tmMonitorTick;
		private System.Windows.Forms.TrackBar tbGain;
		
		/// <summary>
		/// Disposes resources used by the form.
		/// </summary>
		/// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing) {
				if (components != null) {
					components.Dispose();
				}
			}
			base.Dispose(disposing);
		}
		
		/// <summary>
		/// This method is required for Windows Forms designer support.
		/// Do not change the method contents inside the source code editor. The Forms designer might
		/// not be able to load this method if it was changed manually.
		/// </summary>
		private void InitializeComponent()
		{
            this.components = new System.ComponentModel.Container();
            this.btnStart = new System.Windows.Forms.Button();
            this.pbRegionView = new System.Windows.Forms.PictureBox();
            this.pbMotionDetection = new System.Windows.Forms.PictureBox();
            this.lblCurrentLevel = new System.Windows.Forms.Label();
            this.tmMonitorTick = new System.Windows.Forms.Timer(this.components);
            this.tbGain = new System.Windows.Forms.TrackBar();
            this.btnSelectRegion = new System.Windows.Forms.Button();
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.label2 = new System.Windows.Forms.Label();
            this.lblRuch = new System.Windows.Forms.Label();
            this.tbAlarmThreshold = new System.Windows.Forms.TrackBar();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.lblGain = new System.Windows.Forms.Label();
            this.groupBox3 = new System.Windows.Forms.GroupBox();
            this.lblAThreshold = new System.Windows.Forms.Label();
            this.ofdAlarmFile = new System.Windows.Forms.OpenFileDialog();
            this.groupBox4 = new System.Windows.Forms.GroupBox();
            ((System.ComponentModel.ISupportInitialize)(this.pbRegionView)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pbMotionDetection)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.tbGain)).BeginInit();
            this.groupBox1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.tbAlarmThreshold)).BeginInit();
            this.groupBox2.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.SuspendLayout();
            // 
            // btnStart
            // 
            this.btnStart.Location = new System.Drawing.Point(340, 288);
            this.btnStart.Name = "btnStart";
            this.btnStart.Size = new System.Drawing.Size(93, 23);
            this.btnStart.TabIndex = 0;
            this.btnStart.Text = "Start";
            this.btnStart.UseVisualStyleBackColor = true;
            this.btnStart.Click += new System.EventHandler(this.btnStartClick);
            // 
            // pbRegionView
            // 
            this.pbRegionView.Location = new System.Drawing.Point(6, 35);
            this.pbRegionView.Name = "pbRegionView";
            this.pbRegionView.Size = new System.Drawing.Size(200, 200);
            this.pbRegionView.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.pbRegionView.TabIndex = 1;
            this.pbRegionView.TabStop = false;
            // 
            // pbMotionDetection
            // 
            this.pbMotionDetection.Location = new System.Drawing.Point(212, 35);
            this.pbMotionDetection.Name = "pbMotionDetection";
            this.pbMotionDetection.Size = new System.Drawing.Size(200, 200);
            this.pbMotionDetection.TabIndex = 2;
            this.pbMotionDetection.TabStop = false;
            // 
            // lblCurrentLevel
            // 
            this.lblCurrentLevel.AutoSize = true;
            this.lblCurrentLevel.Font = new System.Drawing.Font("Microsoft Sans Serif", 15.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(238)));
            this.lblCurrentLevel.Location = new System.Drawing.Point(24, 43);
            this.lblCurrentLevel.Name = "lblCurrentLevel";
            this.lblCurrentLevel.Size = new System.Drawing.Size(45, 25);
            this.lblCurrentLevel.TabIndex = 4;
            this.lblCurrentLevel.Text = "0%";
            // 
            // tmMonitorTick
            // 
            this.tmMonitorTick.Interval = 16;
            this.tmMonitorTick.Tick += new System.EventHandler(this.tmMonitorTick_Tick);
            // 
            // tbGain
            // 
            this.tbGain.Location = new System.Drawing.Point(6, 19);
            this.tbGain.Maximum = 5;
            this.tbGain.Minimum = 1;
            this.tbGain.Name = "tbGain";
            this.tbGain.Size = new System.Drawing.Size(271, 45);
            this.tbGain.TabIndex = 5;
            this.tbGain.Value = 4;
            this.tbGain.ValueChanged += new System.EventHandler(this.tbGain_ValueChanged);
            // 
            // btnSelectRegion
            // 
            this.btnSelectRegion.Location = new System.Drawing.Point(340, 259);
            this.btnSelectRegion.Name = "btnSelectRegion";
            this.btnSelectRegion.Size = new System.Drawing.Size(93, 23);
            this.btnSelectRegion.TabIndex = 6;
            this.btnSelectRegion.Text = "Wybierz region";
            this.btnSelectRegion.UseVisualStyleBackColor = true;
            this.btnSelectRegion.Click += new System.EventHandler(this.btnSelectRegion_Click);
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.label2);
            this.groupBox1.Controls.Add(this.lblRuch);
            this.groupBox1.Controls.Add(this.pbRegionView);
            this.groupBox1.Controls.Add(this.pbMotionDetection);
            this.groupBox1.Location = new System.Drawing.Point(12, 12);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(421, 241);
            this.groupBox1.TabIndex = 7;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Podgląd";
            // 
            // label2
            // 
            this.label2.Location = new System.Drawing.Point(6, 16);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(200, 15);
            this.label2.TabIndex = 9;
            this.label2.Text = "Region";
            this.label2.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // lblRuch
            // 
            this.lblRuch.Location = new System.Drawing.Point(212, 16);
            this.lblRuch.Name = "lblRuch";
            this.lblRuch.Size = new System.Drawing.Size(200, 15);
            this.lblRuch.TabIndex = 8;
            this.lblRuch.Text = "Detekcja ruchu";
            this.lblRuch.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // tbAlarmThreshold
            // 
            this.tbAlarmThreshold.LargeChange = 10;
            this.tbAlarmThreshold.Location = new System.Drawing.Point(9, 19);
            this.tbAlarmThreshold.Maximum = 100;
            this.tbAlarmThreshold.Minimum = 1;
            this.tbAlarmThreshold.Name = "tbAlarmThreshold";
            this.tbAlarmThreshold.Size = new System.Drawing.Size(271, 45);
            this.tbAlarmThreshold.TabIndex = 8;
            this.tbAlarmThreshold.TabStop = false;
            this.tbAlarmThreshold.Value = 25;
            this.tbAlarmThreshold.ValueChanged += new System.EventHandler(this.tbAlarmThreshold_ValueChanged);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.lblGain);
            this.groupBox2.Controls.Add(this.tbGain);
            this.groupBox2.Location = new System.Drawing.Point(12, 259);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(322, 71);
            this.groupBox2.TabIndex = 11;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Wzmocnienie Δ";
            // 
            // lblGain
            // 
            this.lblGain.AutoSize = true;
            this.lblGain.Location = new System.Drawing.Point(292, 29);
            this.lblGain.Name = "lblGain";
            this.lblGain.Size = new System.Drawing.Size(13, 13);
            this.lblGain.TabIndex = 6;
            this.lblGain.Text = "4";
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.lblAThreshold);
            this.groupBox3.Controls.Add(this.tbAlarmThreshold);
            this.groupBox3.Location = new System.Drawing.Point(12, 336);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Size = new System.Drawing.Size(322, 72);
            this.groupBox3.TabIndex = 12;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "Próg alarmu [%]";
            // 
            // lblAThreshold
            // 
            this.lblAThreshold.AutoSize = true;
            this.lblAThreshold.Location = new System.Drawing.Point(286, 33);
            this.lblAThreshold.Name = "lblAThreshold";
            this.lblAThreshold.Size = new System.Drawing.Size(19, 13);
            this.lblAThreshold.TabIndex = 9;
            this.lblAThreshold.Text = "25";
            // 
            // ofdAlarmFile
            // 
            this.ofdAlarmFile.FileName = "openFileDialog1";
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.lblCurrentLevel);
            this.groupBox4.Location = new System.Drawing.Point(340, 317);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Size = new System.Drawing.Size(93, 91);
            this.groupBox4.TabIndex = 13;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "Poziom wykrycia ruchu";
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(444, 416);
            this.Controls.Add(this.groupBox4);
            this.Controls.Add(this.groupBox3);
            this.Controls.Add(this.groupBox2);
            this.Controls.Add(this.groupBox1);
            this.Controls.Add(this.btnSelectRegion);
            this.Controls.Add(this.btnStart);
            this.Name = "MainForm";
            this.Text = "Sigma-Delta Motion Detection";
            ((System.ComponentModel.ISupportInitialize)(this.pbRegionView)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pbMotionDetection)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.tbGain)).EndInit();
            this.groupBox1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.tbAlarmThreshold)).EndInit();
            this.groupBox2.ResumeLayout(false);
            this.groupBox2.PerformLayout();
            this.groupBox3.ResumeLayout(false);
            this.groupBox3.PerformLayout();
            this.groupBox4.ResumeLayout(false);
            this.groupBox4.PerformLayout();
            this.ResumeLayout(false);

		}

        private System.Windows.Forms.Button btnSelectRegion;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.Label lblRuch;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TrackBar tbAlarmThreshold;
        private System.Windows.Forms.GroupBox groupBox2;
        private System.Windows.Forms.Label lblGain;
        private System.Windows.Forms.GroupBox groupBox3;
        private System.Windows.Forms.Label lblAThreshold;
        private System.Windows.Forms.OpenFileDialog ofdAlarmFile;
        private System.Windows.Forms.GroupBox groupBox4;
    }
}
