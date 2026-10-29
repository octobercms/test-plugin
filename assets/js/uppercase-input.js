/*
 * UppercaseInput converts the value of a text input to uppercase as the user types.
 */
oc.registerControl('uppercase-input', class extends oc.ControlBase {
    connect() {
        this.listen('input', this.onInput);
        this.onInput();
    }

    onInput() {
        const { selectionStart, selectionEnd } = this.element;

        this.element.value = this.element.value.toUpperCase();
        this.element.setSelectionRange(selectionStart, selectionEnd);
    }
});
