#include <stdio.h>

int main() {
    char restart;
    int gugucount = 1;
    do {
        printf("< %d ȸ ���� >\n", gugucount);
        for (int i = 1; i < 10; i++) {
            for (int j = 2; j < 10; j++) {
                printf("%d x %d = %02d\t", j, i, j * i);
            }
            printf("\n");
        }
        gugucount++;
    re:
        printf("���α׷��� �ٽ� �����ϰڽ��ϱ�? (Y/N) : ");
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
            printf("�Է��� ���ĺ� \"%c\"��(��) ������� �ʽ��ϴ�.\n���ĺ��� �ٽ� �Է��ϼ���.\n", restart);
            goto re;
        }
    } while (restart == 1);
    printf("�� %dȸ ���� �� ���α׷��� �����մϴ�.\n", gugucount - 1);
    return 0;
}
