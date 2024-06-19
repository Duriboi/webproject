#include <stdio.h>

int main() {
    char restart;
    int gugucount = 1;
    do {
        printf("< %d 회 실행 >\n", gugucount);
        for (int i = 1; i < 10; i++) {
            for (int j = 2; j < 10; j++) {
                printf("%d x %d = %02d\t", j, i, j * i);
            }
            printf("\n");
        }
        gugucount++;
    re:
        printf("프로그램을 다시 실행하겠습니까? (Y/N) : ");
        scanf_s(" %c", &restart);

        switch (restart) {
        case 'Y':
        case 'y':
            restart = 1;
            break;
        case 'N':
        case 'n':
            restart = 0;
            break;
        default:
            printf("입력한 알파벳 \"%c\"는(은) 허용하지 않습니다.\n알파벳을 다시 입력하세요.\n", restart);
            goto re;
        }
    } while (restart == 1);
    printf("총 %d회 실행 후 프로그램을 종료합니다.\n", gugucount - 1);
    return 0;
}
