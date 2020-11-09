using System;

namespace SDMD
{
	/// <summary>
	/// Description of Morphology.
	/// </summary>
	public class Morphology
	{
		public Morphology()
		{
			
			
		}
		
		public static int getGrayscaleAVG(int color)
		{
			return ((color & 0xff) + ((color >> 8) & 0xff) + ((color >> 16) & 0xff)) / 3;
		}
		
		public static int getGrayscaleARGB(byte gray)
		{
			return ((0xff << 24) | (gray << 16) | (gray << 8) | gray);
		}
		
		public static int getGrayscaleLum(int color)
		{
			return (int)(0.21 * (float)(color & 0xff) + 0.72 * (float)((color >> 8) & 0xff) + 0.07 * (float)((color >> 16) & 0xff));
		}
		
		public static void DilateFilter(
			DirectBitmap sourceBitmap,  
			int matrixSize)
		{
			int[] resultBuffer = new int[sourceBitmap.Width * sourceBitmap.Height]; 
			sourceBitmap.Bits.CopyTo(resultBuffer, 0);

			int filterOffset = (matrixSize - 1) / 2; 
			int calcOffset = 0; 
			int byteOffset = 0; 
   
			for (int offsetY = filterOffset; offsetY < sourceBitmap.Height - filterOffset; offsetY++) 
			{
				for (int offsetX = filterOffset; offsetX < sourceBitmap.Width - filterOffset; offsetX++) 
				{
					byteOffset = offsetY * sourceBitmap.Width + offsetX; 

					byte gray = 0;
					
					for (int filterY = -filterOffset; filterY <= filterOffset; filterY++) { 
						for (int filterX = -filterOffset; filterX <= filterOffset; filterX++) { 
							calcOffset = byteOffset + filterX +	(filterY * sourceBitmap.Width); 

							int srcGray = getGrayscaleAVG(sourceBitmap.Bits[calcOffset]);
							if ((byte)srcGray > gray) {
								gray = (byte)srcGray;
							}
						} 
					}
					resultBuffer[byteOffset] = getGrayscaleARGB(gray);
				}
			}
			
			resultBuffer.CopyTo(sourceBitmap.Bits, 0);
		}
		
		public static void ErodeFilter(
			DirectBitmap sourceBitmap,  
			int matrixSize)
		{
			int[] resultBuffer = new int[sourceBitmap.Width * sourceBitmap.Height]; 
			sourceBitmap.Bits.CopyTo(resultBuffer, 0);
   
			int filterOffset = (matrixSize - 1) / 2; 
			int calcOffset = 0; 
			int byteOffset = 0; 
   
			for (int offsetY = filterOffset; offsetY <	sourceBitmap.Height - filterOffset; offsetY++) {
				for (int offsetX = filterOffset; offsetX < sourceBitmap.Width - filterOffset; offsetX++) {
					byteOffset = offsetY * sourceBitmap.Width + offsetX; 

					byte gray = 255; 
					
					for (int filterY = -filterOffset; filterY <= filterOffset; filterY++) 
					{
						for (int filterX = -filterOffset; filterX <= filterOffset; filterX++) {
							calcOffset = byteOffset + filterX + (filterY * sourceBitmap.Width);

							int srcGray = getGrayscaleAVG(sourceBitmap.Bits[calcOffset]);
							if ((byte)srcGray < gray) {
								gray = (byte)srcGray;
							}
						}
					}
					
					resultBuffer[byteOffset] = getGrayscaleARGB(gray);
				}

   
				
				}
			}

   
			
		}
	}

