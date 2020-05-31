function onFormSubmit(form) {


  const data = new FormData(form);
  const url = form.getAttribute("action");
  const method = form.getAttribute("method") || "POST";

  const query = new URLSearchParams(data).toString();

  fetch(`${url}/?${query}`, { method })
    .then(async (response) => {
      if (response.ok) window.location.reload();
      else {
        const responseData = await response.json();
        alert("Ошибка: " + responseData.message);
      }
    })
    .catch((response) => console.error(response));

  return false;
}
