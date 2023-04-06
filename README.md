<div align="center">

[![CGL](https://github.com/shrugify/zealous-stan/actions/workflows/cgl.yaml/badge.svg)](https://github.com/shrugify/zealous-stan/actions/workflows/cgl.yaml)
[![codecov](https://codecov.io/gh/shrugify/yolo/branch/main/graph/badge.svg?token=5FYSOP5ZUZ)](https://codecov.io/gh/shrugify/yolo)

#  Shrugify 🤷 Yolo
</div>

This package deploys a random commit message generator to [yolo.shrugify.com](https://yolo.shrugify.com).

## ⚡ Usage

1. Visit [yolo.shrugify.com](https://yolo.shrugify.com) to get a random commit message.
2. Retrieve and apply a plain text commit message from the shell:
    ```bash
    git commit -m "$(curl -s https://yolo.shrugify.com/message.txt)"
    ```
3. Pro tip! Create an alias:
    ```bash
    git config --global alias.yolo '!git commit -m "$(curl -s https://yolo.shrugify.com/message.txt)"'
    ```
4. Bonus! Get the original `What The Commit` messages.
    ```bash
    git commit -m "$(curl -s https://yolo.shrugify.com/whatthecommit.txt)"
    ```






## 💛 Acknowledgement
This package massively inspired by one of my favorite projects: [whatthecommit.com](https://whatthecommit.com)
Thanks to [@ngerakines](https://github.com/ngerakines) the many other contributors of [`ngerakines/commitment`](https://github.com/ngerakines/commitment).

## ⭐ License
This project is licensed under [GNU General Public License 3.0 (or later)](LICENSE).
