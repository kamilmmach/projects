using System;

namespace SDMD
{
    class Utils
    {
        public static int getGrayscaleAVG(int color)
        {
            return ((color & 0xff) + ((color >> 8) & 0xff) + ((color >> 16) & 0xff)) / 3;
        }

        public static int getGrayscaleLum(int color)
        {
            return (int)(0.21 * (float)(color & 0xff) + 0.72 * (float)((color >> 8) & 0xff) + 0.07 * (float)((color >> 16) & 0xff));
        }

        public static void clip(ref short num, short min, short max)
        {
            if (num > max)
                num = max;
            else if (num < min)
                num = min;
        }

        public static int GCD(int x, int y)
        {
            return y == 0 ? x : GCD(y, x % y);
        }

        public static int DiffARGB(int col1, int col2)
        {
            //int a = Math.Abs((col1 >> 24 & 0xff) - (col2 >> 24 & 0xff));
            int r = Math.Abs((col1 >> 16 & 0xff) - (col2 >> 16 & 0xff));
            int g = Math.Abs((col1 >> 8 & 0xff) - (col2 >> 8 & 0xff));
            int b = Math.Abs((col1 & 0xff) - (col2 & 0xff));

            return (unchecked((int)0xff000000) | (r << 16) | (g << 8) | b);
        }
    }
}
