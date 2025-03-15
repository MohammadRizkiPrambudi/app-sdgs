let questionIndex = 1; // Indeks untuk soal berikutnya

document.getElementById("addQuestion").addEventListener("click", function () {
    const questionsContainer = document.getElementById("questionsContainer");
    const newQuestionGroup = document.createElement("div");
    newQuestionGroup.classList.add("question-group", "card", "mb-3");
    newQuestionGroup.innerHTML = `
    <div class="card-body">
        <div class="form-group">
            <button type="button" class="btn btn-danger float-end remove-question"><i class="fas fa-minus-circle"></i> Hapus Form Soal</button>
        </div>
        <div class="form-group">
            <label for="question_text">Pertanyaan:</label>
            <textarea name="questions[${questionIndex}][question_text]" class="form-control summernote" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option_a">Opsi A:</label>
                     <input type="text" name="questions[${questionIndex}][option_a]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option_b">Opsi B:</label>
                    <input type="text" name="questions[${questionIndex}][option_b]" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option_c">Opsi C:</label>
                    <input type="text" name="questions[${questionIndex}][option_c]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option_d">Opsi D:</label>
                    <input type="text" name="questions[${questionIndex}][option_d]" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="correct_option">Jawaban Benar:</label>
            <select name="questions[${questionIndex}][correct_option]" class="form-control" required>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select>
        </div>
    </div>
`;

    questionsContainer.appendChild(newQuestionGroup);
    $(newQuestionGroup.querySelector(".summernote")).summernote({
        height: 150, // Tinggi editor
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough", "superscript", "subscript"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
        ],
    });

    questionIndex++; // Tingkatkan indeks untuk soal berikutnya
    newQuestionGroup
        .querySelector(".remove-question")
        .addEventListener("click", function () {
            questionsContainer.removeChild(newQuestionGroup);
        });
});
