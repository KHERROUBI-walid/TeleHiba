import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["dropzone", "input", "message", "preview"];
    static values = {
        invalidFormatMessage: String,
        tooLargeMessage: String,
        validMessage: String,
    };

    connect() {
        this.dropzoneTarget.addEventListener("click", () =>
            this.inputTarget.click()
        );
        this.dropzoneTarget.addEventListener(
            "dragover",
            this.onDragOver.bind(this)
        );
        this.dropzoneTarget.addEventListener(
            "dragleave",
            this.onDragLeave.bind(this)
        );
        this.dropzoneTarget.addEventListener("drop", this.onDrop.bind(this));
        this.inputTarget.addEventListener(
            "change",
            this.onInputChange.bind(this)
        );
    }

    onDragOver(event) {
        event.preventDefault();
        this.dropzoneTarget.classList.add("bg-[#D5DFFF]");
    }

    onDragLeave(event) {
        event.preventDefault();
        this.dropzoneTarget.classList.remove("bg-[#D5DFFF]");
    }

    onDrop(event) {
        event.preventDefault();
        this.dropzoneTarget.classList.remove("bg-[#D5DFFF]");
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            this.inputTarget.files = files;
            this.validateFile(files[0]);
        }
    }

    onInputChange() {
        if (this.inputTarget.files.length > 0) {
            this.validateFile(this.inputTarget.files[0]);
        }
    }

    validateFile(file) {
        const maxSize = 2 * 1024 * 1024; // 2 Mo
        const validTypes = ["image/jpeg", "image/png", "image/webp"];
        let message = "";
        let borderColorClass = "";
        let textColorClass = "";

        if (!validTypes.includes(file.type)) {
            message = this.invalidFormatMessageValue;
            borderColorClass = "border-red-500";
            textColorClass = "text-red-600";
            this.clearPreview();
        } else if (file.size > maxSize) {
            message = this.tooLargeMessageValue;
            borderColorClass = "border-red-500";
            textColorClass = "text-red-600";
            this.clearPreview();
        } else {
            message = this.validMessageValue.replace("%filename%", file.name);
            borderColorClass = "border-green-500";
            textColorClass = "text-green-600";
            this.showPreview(file);
        }

        this.dropzoneTarget.classList.remove(
            "border-[#8C85FF]",
            "border-red-500",
            "border-green-500"
        );
        this.dropzoneTarget.classList.add(borderColorClass);

        this.messageTarget.classList.remove("text-red-600", "text-green-600");
        this.messageTarget.classList.add(textColorClass);

        this.messageTarget.textContent = message;
    }

    showPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            this.previewTarget.innerHTML = `<img src="${e.target.result}" alt="Preview" class="mx-auto mt-4 max-h-40 rounded-md object-contain" />`;
        };
        reader.readAsDataURL(file);
    }

    clearPreview() {
        this.previewTarget.innerHTML = "";
    }
}
