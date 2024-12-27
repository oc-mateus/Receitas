<?php 
require "config.php";
include(HEADER_TEMPLATE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
   
    
  </style>
</head>
<body>
  <div style="font-family: Arial; text-align: center; margin-top: 50px;">
    <h1>Recipe Finder</h1>
    <p>Procure pelos ingredientes:</p>
    <input type="text" class="input" id="ingredients" placeholder="Digite aqui...">
    <button id="searchButton">Procurar</button>
    <div id="results" style="margin-top: 30px;"></div>
  </div>
<script>
// HTML Setup


// JavaScript Logic
const searchButton = document.getElementById('searchButton');
const resultsDiv = document.getElementById('results');

searchButton.addEventListener('click', () => {
  const ingredients = document.getElementById('ingredients').value;
  if (!ingredients) {
    alert('Por favor insira pelo menos um ingrediente!');
    return;
  }

  const query = ingredients.split(',').map(ing => ing.trim()).join(',');
  const url = `https://www.themealdb.com/api/json/v1/1/filter.php?i=${query}`;

  fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to fetch recipes.');
      }
      return response.json();
    })
    .then(data => {
      if (data.meals) {
        displayResults(data.meals);
      } else {
        resultsDiv.innerHTML = '<p>Nenhuma receita encontrada para os ingredientes indicados.</p>';
      }
    })
    .catch(error => {
      resultsDiv.innerHTML = `<p>Error: ${error.message}</p>`;
    });
});

function displayResults(meals) {
  const html = meals.map(meal => `
    <div style="border: 1px solid #ccc;border-radius: 20px; padding: 10px; margin: 10px; display: inline-block; text-align: center; width: 200px;">
      <img src="${meal.strMealThumb}" alt="${meal.strMeal}" style="width: 100%; height: auto;">
      <p><strong>${meal.strMeal}</strong></p>
      <a href="https://www.themealdb.com/meal/${meal.idMeal}" target="_blank"><button>Ver Receita:</button></a>
    </div>
  `).join('');

  resultsDiv.innerHTML = html;
}
</script>
</body>
</html>