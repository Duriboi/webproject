#include <stdio.h>
#include <stdlib.h>
#include <time.h>

#define P 2 
#define R 3 
#define C 5 

int main()
{ 
    int list[P][R][C];
    char restart;
    do {
        printf("\n3���� �迭 ��Ҹ� �������� ����ϴ� ���α׷�\n");
        srand((int)time(NULL));

        for (int myuncount = 0; myuncount < P; myuncount++) {
            printf("[ %d�� ] ���\n", myuncount + 1);
            for (int hangcount = 0; hangcount < R; hangcount++) {
                printf("< %d�� ��� > ", hangcount + 1);
                for (int yulcount = 0; yulcount < C; yulcount++) {
                    list[myuncount][hangcount][yulcount] = rand() % 100;
                    printf("%d ", list[myuncount][hangcount][yulcount]);
                }
                printf("\n");
            }
        }
        
        printf("\n���α׷� ���� �Ϸ�!\n");

    point:

        printf("���α׷��� �ٽ� �����ϰڽ��ϱ�? (Y/N) : ");
        scanf_s(" %c", &restart);

        if (restart != 'Y' && restart !='N') {
            printf("���ĺ� �Է� ����!\n���ĺ��� �ٽ� �Է��ϼ���.\n\n");
            goto point;
        }
        else if (restart == 'N') {
            restart == 'X';
        }
        else if (restart == 'Y') {
            restart = 'Y';
        }

    } while (restart == 'Y');
    printf("���α׷� ����\n");
    return 0;
}
