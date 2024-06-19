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
        printf("\n3차원 배열 요소를 랜덤으로 출력하는 프로그램\n");
        srand((int)time(NULL));

        for (int myuncount = 0; myuncount < P; myuncount++) {
            printf("[ %d면 ] 출력\n", myuncount + 1);
            for (int hangcount = 0; hangcount < R; hangcount++) {
                printf("< %d행 출력 > ", hangcount + 1);
                for (int yulcount = 0; yulcount < C; yulcount++) {
                    list[myuncount][hangcount][yulcount] = rand() % 100;
                    printf("%d ", list[myuncount][hangcount][yulcount]);
                }
                printf("\n");
            }
        }
        
        printf("\n프로그램 수행 완료!\n");

    point:

        printf("프로그램을 다시 시작하겠습니까? (Y/N) : ");
        scanf_s(" %c", &restart);

        if (restart != 'Y' && restart !='N') {
            printf("알파벳 입력 오류!\n알파벳을 다시 입력하세요.\n\n");
            goto point;
        }
        else if (restart == 'N') {
            restart == 'X';
        }
        else if (restart == 'Y') {
            restart = 'Y';
        }

    } while (restart == 'Y');
    printf("프로그램 종료\n");
    return 0;
}
