#include <stdio.h>

void INCHTOCM(float x)
{
    printf("��>%.2f��ġ(inch)�� %.2f��Ƽ����(cm)\n\n", x, x * 2.5399);
    printf("���������� ȯ���� �����Ͽ����ϴ�.\n\n");
}

void PYUNGTOPB(float x)
{
    printf("��>%.2f���� %.2f������\n\n", x, x * 3.3058);
    printf("���������� ȯ���� �����Ͽ����ϴ�.\n\n");
}
int main()
{
    char whattodo;
    float input;
    do
    {
        printf("\nA. ��ġ�� ��Ƽ���ͷ� ȯ���ϴ� ���α׷�\n");
        printf("B. ���� �����ͷ� ȯ���ϴ� ���α׷�\n");
        printf("Q. ���α׷� ����\n\n");
        printf("���� : ");
        scanf_s(" %c", &whattodo);

        if (whattodo == 'a' || whattodo == 'A')
        {
            printf("A. ��ġ�� ��Ƽ���ͷ� ȯ���ϴ� ���α׷�\n");
            printf("��> ��ġ(inch)�� �Է��ϼ��� : ");
            scanf_s("%f", &input);
            printf("\n[��ġ�� ��Ƽ���ͷ� ȯ���ϴ� �Լ� ȣ��]\n\n");
            INCHTOCM(input);
        }
        else if (whattodo == 'b' || whattodo == 'B')
        {
            printf("B. ���� �����ͷ� ȯ���ϴ� ���α׷�\n");
            printf("��> ���� �Է��ϼ��� : ");
            scanf_s("%f", &input);
            printf("\n[���� �����ͷ� ȯ���ϴ� �Լ� ȣ��]\n\n");
            PYUNGTOPB(input);
        }
        else if (whattodo == 'q' || whattodo == 'Q')
        {
            printf("���α׷��� �����մϴ�.\n");
            return 0;
        }
        else
            continue;
    } while (1);

    return 0;
}

