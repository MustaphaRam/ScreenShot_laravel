<template>
    <div>
      <p v-if="message">Message from Controller: {{ message }}</p>
      <div class="container py-4 px-3 mx-auto">
        <div class="row">
          <button class="btn btn-primary" @click="reverseMessage">Reverse Message</button>
        </div>
        <div class="row">
          <img v-for="img in images" :src="require(`../images/${img}`)" width="200"/>
        </div>
      </div> 
    </div>

    <h2 id="visits"></h2>
</template>

<script>
// Import Axios if you haven't already
import axios from 'axios';

export default {
    data() {
    return {
      name: 'Mustapha', // Set the default name or leave it empty
      message: '', // Create a data property to store the message received from the controller
    };
  },
  mounted() {
    // Call the API directly inside the mounted hook
    axios.get(`/show`, {
      params: {
        name: this.name, // Add any query parameters you want to send to the controller function
      },
    })
      .then(response => {
        this.message = response.data.message; // Update the message data property with the received message
      })
      .catch(error => {
        console.error(error); // Handle any errors that occur during the API call
      });
  },
};

  

</script>
