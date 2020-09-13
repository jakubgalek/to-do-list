var Input;
(function (Input) {
    Input["Title"] = "#i_title";
    Input["Message"] = "#i_message";
    Input["Image"] = "#i_image";
})(Input || (Input = {}));
var TaskMessage;
(function (TaskMessage) {
    TaskMessage["Title"] = "#title";
    TaskMessage["Message"] = "#message";
    TaskMessage["Image"] = "#image";
})(TaskMessage || (TaskMessage = {}));
var Type;
(function (Type) {
    Type["Text"] = "text";
    Type["Textarea"] = "textarea";
    Type["File"] = "file";
})(Type || (Type = {}));
var input = getId(), string;
var taskMessage = getType(), string;
var click = document.body.querySelector(TaskMessage.Title || TaskMessage.Message || TaskMessage.Image);
click.addEventListener("click", function () {
    processReplace(input, taskMessage);
});
function getId(input, taskMessage) {
    return input + "  " + taskMessage;
}
function getType(input, taskMessage) {
    return input + "  " + taskMessage;
}
function processReplace(input, taskMessage) {
    input.replaceWith.taskMessage;
    input.type = getType();
    var ;
    (function () {
    })( || ( = {}));
    ;
}
