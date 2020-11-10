﻿using System;
using System.Drawing;
using System.Drawing.Imaging;
using System.Runtime.InteropServices;

namespace SDMD
{
	/// <summary>
	/// Description of DirectBitmap.
	/// </summary>
	public class DirectBitmap : IDisposable, ICloneable
	{
		public Bitmap Bitmap { get; private set; }
		public Int32[] Bits { get; private set; }
		public bool Disposed { get; private set; }
		public int Height { get; private set; }
		public int Width { get; private set; }

		protected GCHandle BitsHandle { get; private set; }

		public DirectBitmap(int width, int height)
		{
			Width = width;
			Height = height;
			Bits = new Int32[width * height];
			BitsHandle = GCHandle.Alloc(Bits, GCHandleType.Pinned);
			Bitmap = new Bitmap(width, height, width * 4, PixelFormat.Format32bppArgb, BitsHandle.AddrOfPinnedObject());
		}

        public void SeedWith8bppGrayscale(short[] data)
        {
            long size = Width * Height;
            if (data.Length != size)
                return;

            for (int i = 0; i < size; ++i)
            {
                int gray = (int)data[i];
                Bits[i] = Color.FromArgb(gray, gray, gray).ToArgb();
            }
                

        }

		public void Dispose()
		{
			if (Disposed)
				return;
			Disposed = true;
			Bitmap.Dispose();
			BitsHandle.Free();
		}
		
		// deep
		public object Clone()
		{
			DirectBitmap clone = new DirectBitmap(Width, Height);
			Bits.CopyTo(clone.Bits, 0);
			
			return clone;
		}
	}
}
