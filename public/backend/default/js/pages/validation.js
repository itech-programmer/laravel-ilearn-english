const question_title = document.getElementById('question_title');
const chapter = document.getElementById('chapter');
// const time_limit = document.getElementById('time_limit');
// const point = document.getElementById('point');

question_title.addEventListener('input', evt => {
    const value = question_title.value;
    if (!value) {
        question_title.classList.add('');
        return;
    }
    const trimmed = value.trim();

    if (trimmed) {
        question_title.classList.remove('is-invalid');
        question_title.classList.add('is-valid');
    } else {
        question_title.classList.remove('is-valid');
        question_title.classList.add('is-invalid');
    }
});
chapter.addEventListener('click', evt => {
    const trimmed = chapter.value.trim();

    if (trimmed !== " ") {
        chapter.classList.remove('is-invalid');
        chapter.classList.add('is-valid');
    } else {
        chapter.classList.remove('is-valid');
        chapter.classList.add('is-invalid');
    }
});
// time_limit.addEventListener('input', evt => {
//     const value = time_limit.value;
//     if (!value) {
//         time_limit.classList.add('');
//         return;
//     }
//     const trimmed = value.trim();
//
//     if (trimmed) {
//         time_limit.classList.remove('is-invalid');
//         time_limit.classList.add('is-valid');
//     } else {
//         time_limit.classList.remove('is-valid');
//         time_limit.classList.add('is-invalid');
//     }
// });
// point.addEventListener('input', evt => {
//     const value = point.value;
//     if (!value) {
//         point.classList.add('');
//         return;
//     }
//     const trimmed = value.trim();
//
//     if (trimmed) {
//         point.classList.remove('is-invalid');
//         point.classList.add('is-valid');
//     } else {
//         point.classList.remove('is-valid');
//         point.classList.add('is-invalid');
//     }
// });

const answer_title_1 = document.getElementById('answer_title_1');
const type_1 = document.getElementById('type_1');

answer_title_1.addEventListener('input', evt => {
    const value = answer_title_1.value;
    if (!value) {
        answer_title_1.classList.add('');
        return;
    }
    const trimmed = value.trim();

    if (trimmed) {
        answer_title_1.classList.remove('is-invalid');
        answer_title_1.classList.add('is-valid');
    } else {
        answer_title_1.classList.remove('is-valid');
        answer_title_1.classList.add('is-invalid');
    }
});
type_1.addEventListener('click', evt => {
    const trimmed = type_1.value.trim();

    if (trimmed !== " ") {
        type_1.classList.remove('is-invalid');
        type_1.classList.add('is-valid');
    } else {
        type_1.classList.remove('is-valid');
        type_1.classList.add('is-invalid');
    }
});

const answer_title_2 = document.getElementById('answer_title_2');
const type_2 = document.getElementById('type_2');

answer_title_2.addEventListener('input', evt => {
    const value = answer_title_2.value;
    if (!value) {
        answer_title_2.classList.add('');
        return;
    }
    const trimmed = value.trim();

    if (trimmed) {
        answer_title_2.classList.remove('is-invalid');
        answer_title_2.classList.add('is-valid');
    } else {
        answer_title_2.classList.remove('is-valid');
        answer_title_2.classList.add('is-invalid');
    }
});
type_2.addEventListener('click', evt => {
    const trimmed = type_2.value.trim();

    if (trimmed !== " ") {
        type_2.classList.remove('is-invalid');
        type_2.classList.add('is-valid');
    } else {
        type_2.classList.remove('is-valid');
        type_2.classList.add('is-invalid');
    }
});

const answer_title_3 = document.getElementById('answer_title_3');
const type_3 = document.getElementById('type_3');

answer_title_3.addEventListener('input', evt => {
    const value = answer_title_3.value;
    if (!value) {
        answer_title_3.classList.add('');
        return;
    }
    const trimmed = value.trim();

    if (trimmed) {
        answer_title_3.classList.remove('is-invalid');
        answer_title_3.classList.add('is-valid');
    } else {
        answer_title_3.classList.remove('is-valid');
        answer_title_3.classList.add('is-invalid');
    }
});
type_3.addEventListener('click', evt => {
    const trimmed = type_3.value.trim();

    if (trimmed !== " ") {
        type_3.classList.remove('is-invalid');
        type_3.classList.add('is-valid');
    } else {
        type_3.classList.remove('is-valid');
        type_3.classList.add('is-invalid');
    }
});

const answer_title_4 = document.getElementById('answer_title_4');
const type_4 = document.getElementById('type_4');

answer_title_4.addEventListener('input', evt => {
    const value = answer_title_4.value;
    if (!value) {
        answer_title_4.classList.add('');
        return;
    }
    const trimmed = value.trim();

    if (trimmed) {
        answer_title_4.classList.remove('is-invalid');
        answer_title_4.classList.add('is-valid');
    } else {
        answer_title_4.classList.remove('is-valid');
        answer_title_4.classList.add('is-invalid');
    }
});
type_4.addEventListener('click', evt => {
    const trimmed = type_4.value.trim();

    if (trimmed !== " ") {
        type_4.classList.remove('is-invalid');
        type_4.classList.add('is-valid');
    } else {
        type_4.classList.remove('is-valid');
        type_4.classList.add('is-invalid');
    }
});
