#include <stdio.h>

void INCHTOCM(float x)
{
    printf("답>%.2f인치(inch)는 %.2f센티미터(cm)\n\n", x, x * 2.5399);
    printf("성공적으로 환산을 수행하였습니다.\n\n");
}

void PYUNGTOPB(float x)
{
    printf("답>%.2f평은 %.2f평방미터\n\n", x, x * 3.3058);
    printf("성공적으로 환산을 수행하였습니다.\n\n");
}
int main()
{
    char whattodo;
    float input;
    do
    {
        printf("\nA. 인치를 센티미터로 환산하는 프로그램\n");
        printf("B. 평을 평방미터로 환산하는 프로그램\n");
        printf("Q. 프로그램 종료\n\n");
        printf("선택 : ");
        scanf_s(" %c", &whattodo);

        if (whattodo == 'a' || whattodo == 'A')
        {
            printf("A. 인치를 센티미터로 환산하는 프로그램\n");
            printf("문> 인치(inch)를 입력하세요 : ");
            scanf_s("%f", &input);
            printf("\n[인치를 센티미터로 환산하는 함수 호출]\n\n");
            INCHTOCM(input);
        }
        else if (whattodo == 'b' || whattodo == 'B')
        {
            printf("B. 평을 평방미터로 환산하는 프로그램\n");
            printf("문> 평을 입력하세요 : ");
            scanf_s("%f", &input);
            printf("\n[평을 평방미터로 환산하는 함수 호출]\n\n");
            PYUNGTOPB(input);
        }
        else if (whattodo == 'q' || whattodo == 'Q')
        {
            printf("프로그램을 종료합니다.\n");
            return 0;
        }
        else
            continue;
    } while (1);

    return 0;
}

