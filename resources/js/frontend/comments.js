const commentForm = document.querySelector('[data-comment-form]');

if (commentForm) {
    const feedback = document.querySelector('[data-comment-feedback]');
    const submitButton = commentForm.querySelector('[data-comment-submit]');

    commentForm.addEventListener('submit', (event) => {
        event.preventDefault();
        feedback.classList.add('d-none');
        submitButton.disabled = true;

        const request = new XMLHttpRequest();
        request.open('POST', commentForm.action);
        request.setRequestHeader('Accept', 'application/json');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        request.onload = () => {
            let result = {};

            try {
                result = JSON.parse(request.responseText);
            } catch {
                result = {};
            }

            if (request.status < 200 || request.status >= 300) {
                const validationMessages = Object.values(result.errors ?? {}).flat();
                const message = validationMessages[0] ?? result.message ?? 'Your comment could not be submitted. Please try again.';

                feedback.className = 'alert alert-danger';
                feedback.textContent = message;
                feedback.classList.remove('d-none');

                return;
            }

            feedback.className = 'alert alert-success';
            feedback.textContent = result.message ?? 'Your comment has been submitted and is awaiting moderation.';
            feedback.classList.remove('d-none');
            commentForm.reset();
        };

        request.onerror = () => {
            feedback.className = 'alert alert-danger';
            feedback.textContent = 'A network error prevented your comment from being submitted. Please try again.';
            feedback.classList.remove('d-none');
        };

        request.onloadend = () => {
            submitButton.disabled = false;
        };

        request.send(new FormData(commentForm));
    });
}
