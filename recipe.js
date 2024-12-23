const recipeArr = [
  {
    id: 1,
    name: 'Biryani',
    description: 'A delicious rice dish',
    ingredients: ['rice', 'chicken', 'spices', 'onions', 'tomatoes', 'yogurt'],
    directions: ['Cook rice', 'Cook chicken', 'Mix together'],
  },
  {
    id: 2,
    name: 'Chicken Fried Rice',
    description: 'A delicious rice dish',
    ingredients: ['rice', 'chicken', 'spices', 'onions', 'tomatoes', 'yogurt'],
    directions: ['Cook rice', 'Cook chicken', 'Mix together'],
  },
  {
    id: 3,
    name: 'Chicken Curry',
    description: 'A delicious rice dish',
    ingredients: ['rice', 'chicken', 'spices', 'onions', 'tomatoes', 'yogurt'],
    directions: ['Cook rice', 'Cook chicken', 'Mix together'],
  },
];

let editRecipeIndex = null;  // To track which recipe is being edited

function display() {
  const recipeSection = document.querySelector('.recipe-section');
  recipeSection.innerHTML = ''; // Clear the existing content
  const recipeDiv = document.createElement('div');
  recipeDiv.classList.add('recipe');
  recipeSection.appendChild(recipeDiv);

  const heading = document.createElement('h2');
  heading.classList.add('recipe-heading');
  heading.textContent = 'Recipes';
  recipeDiv.appendChild(heading);

  const recipeListDiv = document.createElement('div');
  recipeListDiv.classList.add('recipe-list');
  recipeDiv.appendChild(recipeListDiv);

  recipeArr.forEach((recipe, index) => {
    const recipeItem = document.createElement('div');
    recipeItem.classList.add('recipe-item');
    recipeListDiv.appendChild(recipeItem);

    const recipeName = document.createElement('h3');
    recipeName.classList.add('recipe-name');
    recipeName.textContent = recipe.name;
    recipeItem.appendChild(recipeName);

    const recipeDescription = document.createElement('p');
    recipeDescription.classList.add('recipe-description');
    recipeDescription.textContent = recipe.description;
    recipeItem.appendChild(recipeDescription);

    const recipeIngredients = document.createElement('ul');
    recipeIngredients.classList.add('recipe-ingredients');
    recipeItem.appendChild(recipeIngredients);

    recipe.ingredients.forEach((ingredient) => {
      const recipeIngredient = document.createElement('li');
      recipeIngredient.classList.add('recipe-ingredient');
      recipeIngredient.textContent = ingredient;
      recipeIngredients.appendChild(recipeIngredient);
    });

    const recipeDirectionsHeading = document.createElement('h4');
    recipeDirectionsHeading.classList.add('recipe-directions-heading');
    recipeDirectionsHeading.textContent = 'Directions to Cook';
    recipeItem.appendChild(recipeDirectionsHeading);

    const recipeDirections = document.createElement('ol');
    recipeDirections.classList.add('recipe-directions');
    recipeItem.appendChild(recipeDirections);

    recipe.directions.forEach((direction) => {
      const recipeDirection = document.createElement('li');
      recipeDirection.classList.add('recipe-direction');
      recipeDirection.textContent = direction;
      recipeDirections.appendChild(recipeDirection);
    });

    const deleteButton = document.createElement('button');
    deleteButton.classList.add('delete-button');
    deleteButton.textContent = 'Delete Recipe';
    deleteButton.addEventListener('click', () => deleteRecipe(index));
    recipeItem.appendChild(deleteButton);

    // Add an Edit button
    const editButton = document.createElement('button');
    editButton.classList.add('edit-button');
    editButton.textContent = 'Edit Recipe';
    editButton.addEventListener('click', () => editRecipe(index));
    recipeItem.appendChild(editButton);
  });
}

function deleteRecipe(recipeIndex) {
  recipeArr.splice(recipeIndex, 1);
  display();
}

function addRecipe() {
  const recipeForm = document.getElementById('recipe-form');
  if (!recipeForm.checkValidity()) {
    alert('Please fill all the fields');
    return;
  }

  const newRecipe = {
    id: recipeArr.length + 1,
    name: recipeForm.querySelector('#recipe-name').value,
    description: recipeForm.querySelector('#recipe-description').value,
    ingredients: recipeForm.querySelector('#recipe-ingredients').value.split(',').map((item) => item.trim()),
    directions: recipeForm.querySelector('#recipe-directions').value.split('\n').map((item) => item.trim()),
  };

  if (editRecipeIndex !== null) {
    // If editing an existing recipe
    recipeArr[editRecipeIndex] = newRecipe;
    editRecipeIndex = null;  // Reset
  } else {
    // If adding a new recipe
    recipeArr.push(newRecipe);
  }

  // Clear form fields
  recipeForm.reset();

  // Update the displayed recipes
  display();
}

// Edit a recipe
function editRecipe(recipeIndex) {
  const recipeForm = document.getElementById('recipe-form');
  const recipe = recipeArr[recipeIndex];

  // Populate the form with the selected recipe data
  recipeForm.querySelector('#recipe-name').value = recipe.name;
  recipeForm.querySelector('#recipe-description').value = recipe.description;
  recipeForm.querySelector('#recipe-ingredients').value = recipe.ingredients.join(', ');
  recipeForm.querySelector('#recipe-directions').value = recipe.directions.join('\n');

  // Set the index of the recipe being edited
  editRecipeIndex = recipeIndex;
}

// Call display to initially show recipes
display();
