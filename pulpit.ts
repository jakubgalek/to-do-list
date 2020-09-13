enum Input {
    Title = '#i_title',
    Message = '#i_message',
    Image = '#i_image'
}

enum TaskMessage {
    Title = '#title',
    Message = '#message',
    Image = '#image'
}

enum Type {
    Text = 'text',
    Textarea = 'textarea',
    File = 'file'
}
const input: enum = getId(): string;
const taskMessage: enum = getType(): string;

let click = <HTMLElement>document.body.querySelector(TaskMessage.Title || TaskMessage.Message || TaskMessage.Image);
click.addEventListener("click", () => {
    processReplace(input, taskMessage);
});

function getId(input: string, taskMessage: string): string {

    return `${input}  ${taskMessage}`;
}
function getType(input: string, taskMessage: string): string {

    return `${input}  ${taskMessage}`;
}

function processReplace(input, taskMessage) {

    input.replaceWith.taskMessage;
    input.type = getType(): enum;

}