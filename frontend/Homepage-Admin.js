window.onload = function () {
  const artName = document.getElementById("article-name-5");

  console.log("start fetch");
  fetch('/api/articles/get', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        from: "Crimereads"
    })
  })
    .then(response => response.json())
    .then(data => {
        artName.innerText = JSON.stringify(data);
    })
    .catch(error => {
        console.error(error);
        artName.innerText = 'An error occurred while fetching the data.';
    });

}