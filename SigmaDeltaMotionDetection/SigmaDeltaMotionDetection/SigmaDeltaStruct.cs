using System;

namespace SDMD
{
	/// <summary>
	/// Description of SigmaDeltaStruct.
	/// </summary>
	public class SigmaDeltaStruct : IDisposable, ICloneable
	{		
		public DirectBitmap BitmapData { get; private set; }
		public bool Disposed { get; private set; }
		public short[] FirstBgEstimator { get; private set; }
		public short[] SecondBgEstimator { get; private set; }
        public int Width { get { return BitmapData.Width; } }
        public int Height { get { return BitmapData.Height; } }

        public SigmaDeltaStruct(int width, int height)
		{
			BitmapData = new DirectBitmap(width, height);
			FirstBgEstimator = new short[width * height];
			SecondBgEstimator = new short[width * height];

			Disposed = false;
		}
		
		public SigmaDeltaStruct(SigmaDeltaStruct sds)
		{
			BitmapData = (DirectBitmap)sds.BitmapData.Clone();
			FirstBgEstimator = new short[sds.BitmapData.Width * sds.BitmapData.Height];
			SecondBgEstimator = new short[sds.BitmapData.Width * sds.BitmapData.Height];
			sds.FirstBgEstimator.CopyTo(FirstBgEstimator, 0);
			sds.SecondBgEstimator.CopyTo(SecondBgEstimator, 0);
			Disposed = false;
		}

        public void PopulateEstimators()
        {
            for (int i = 0; i < FirstBgEstimator.Length; ++i)
            {
                short gray = (short)Utils.getGrayscaleLum(BitmapData.Bits[i]);
                FirstBgEstimator[i] = gray;
                SecondBgEstimator[i] = 0;
            }
        }
		
		public void Dispose()
		{
			if(Disposed)
				return;
			
			BitmapData.Dispose();
		}
		
		public object Clone()
		{
			return new SigmaDeltaStruct(this);
		}
	}
}
