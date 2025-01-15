"use strict";
let i = 1;
document.querySelector(`#full-w`).addEventListener(`click`, function () {
  if (i === 1) {
    document.querySelector(`.active`).classList.add(`non-active`);
    document.querySelector(`.active`).classList.remove(`active`);

    document
      .querySelector(`.active:nth-of-type(2)`)
      .classList.add(`non-active`);
    document.querySelector(`.active:nth-of-type(2)`).classList.remove(`active`);
    i++;
  } else {
    document.querySelector(`.non-active`).classList.add(`active`);
    document.querySelector(`.non-active`).classList.remove(`non-active`);

    document
      .querySelector(`.non-active:nth-of-type(2)`)
      .classList.add(`active`);
    document
      .querySelector(`.non-active:nth-of-type(2)`)
      .classList.remove(`non-active`);
    i--;
  }
});
