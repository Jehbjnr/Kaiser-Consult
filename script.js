const questions = document.querySelectorAll(".faq-question");

questions.forEach((question) => {
  question.addEventListener("click", () => {
    const answer = question.nextElementSibling;
    const isOpen = answer.style.display === "block";
    
    // Close all open answers
    document.querySelectorAll(".faq-answer").forEach((ans) => {
      ans.style.display = "none";
    });

    // Toggle the clicked one
    answer.style.display = isOpen ? "none" : "block";
  });
});

