#include <iostream>
#include <cstdint>
#include <ctime>
#include <cmath>
#include <cstdlib>

const int GENERATIONS = 20000000;

size_t WIDTH = 0;
size_t HEIGHT = 0;
size_t SIZE = WIDTH * HEIGHT;
uint8_t *IMAGE_ORIGINAL;

const size_t SPECIMEN_N = 100;
const size_t BEST_SPECIMEN_N = 2;

uint8_t *SPECIMENS[SPECIMEN_N];
uint8_t *BEST_SPECIMENS[BEST_SPECIMEN_N];

int gen = 0;

// simple score structure, idx is the index of the specimen in the array
struct score_s {
	int idx = 0;
	unsigned long long score = 0;
};

// Mutates every single specimen by drawing a rectangle of random size and intensity 
void mutate()
{
	for (size_t s_idx = 0; s_idx < SPECIMEN_N; ++s_idx)
	{
		size_t x = rand() % WIDTH - 1;
		size_t y = rand() % HEIGHT - 1;
		size_t w = rand() % (WIDTH - x - 1) + 1;
		size_t h = rand() % (HEIGHT - y - 1) + 1;
		uint8_t intensity = rand() & 0xff;

		for (size_t j = y; j < (y + h); ++j)
			for (size_t i = x; i < (x + w); ++i)
				SPECIMENS[s_idx][j * WIDTH + i] = (SPECIMENS[s_idx][j * WIDTH + i] + intensity) >> 1;
	}
}

/* Scores every specimen by suming mean square error (difference squared) for every pixel.
* The lower the score is, the closer the speciman is to the original
*/
void score()
{
	score_s scores[SPECIMEN_N] = { 0 };

	for (size_t s_idx = 0; s_idx < SPECIMEN_N; ++s_idx)
	{
		scores[s_idx].idx = s_idx;

		for(size_t y = 0; y < HEIGHT; ++y)
		{
			for(size_t x = 0; x < WIDTH; ++x)
			{ 
				long ox = (long)IMAGE_ORIGINAL[y * WIDTH + x];
				long sx = (long)SPECIMENS[s_idx][y * WIDTH + x];
				
				scores[s_idx].score += ((ox - sx) * (ox - sx));
			}
		}

	}

	// Sort specimens by score
	qsort(&scores[0], SPECIMEN_N, sizeof(score_s), [](const void* lhs, const void* rhs) {
		score_s a = *((score_s*)lhs); 
		score_s b = *((score_s*)rhs);

		if (a.score < b.score)
			return -1;
		else if (a.score > b.score)
			return 1;

		return 0;
	});


	for (int i = 0; i < BEST_SPECIMEN_N; ++i)
	{
		memcpy(BEST_SPECIMENS[i], SPECIMENS[scores[i].idx], SIZE);
	}
}

// copy best specimens throught all specimen
void cross()
{
	for (int i = 0; i < SPECIMEN_N; ++i)
	{
		memcpy(SPECIMENS[i], BEST_SPECIMENS[i % BEST_SPECIMEN_N], SIZE);
	}
}

// dumps the result to file
void dump_result()
{
	if (gen % 500)
		return;

	char fname[256] = { 0 };
	sprintf_s(fname, 256, "out\\best_%.5i.raw", gen);
	FILE* f = fopen(fname, "wb");
	if(f == NULL)
	{
		std::cout << "Can't open the output file.\n";
		exit(1);
	}
	fwrite(BEST_SPECIMENS[0], SIZE, 1, f);
	fclose(f);
}

int main(int argc, char** argv)
{
	srand(time(NULL));
	if (argc < 4)
	{
		std::cout << "Usage: " << argv[0] << " <filename> [width] [height]\n";
		return 1;
	}

	WIDTH = atoi(argv[2]);
	HEIGHT = atoi(argv[3]);
	SIZE = WIDTH * HEIGHT;

	IMAGE_ORIGINAL = new uint8_t[SIZE];


	FILE* f = fopen(argv[1], "rb");
	if (f == NULL)
	{
		std::cout << "Can't open the input file.\n";
		return 1;
	}

	size_t file_size = ftell(f);
	rewind(f);

	fread(IMAGE_ORIGINAL, sizeof(uint8_t), SIZE, f);
	fclose(f);

	for (int i = 0; i < SPECIMEN_N; ++i)
	{
		SPECIMENS[i] = new uint8_t[SIZE];
	}

	for (int i = 0; i < BEST_SPECIMEN_N; ++i)
	{
		BEST_SPECIMENS[i] = new uint8_t[SIZE];
	}


	for (; gen < GENERATIONS; ++gen)
	{
		std::cout << "Generation " << gen << '\n';
		std::cout << "Step 1\n";
		mutate();
		std::cout << "Step 2\n";
		score();
		std::cout << "Step 3\n";
		cross();

		dump_result();
	}

	return 0;
}