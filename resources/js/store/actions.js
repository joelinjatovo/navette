let actions = {
  ADD_NOTIFICATION({commit}, notification) {
    return new Promise((resolve, reject) => {
      axios.post(`/notifications`, notification)
        .then(response => {
          resolve(response)
        }).catch(err => {
          reject(err)
      })
    })
  },

  GET_NOTIFICATIONS({commit}) {
    axios.get('/notifications')
      .then(res => {
        {
          console.log(res);
          commit('GET_NOTIFICATIONS', res.data)
        }
      })
      .catch(err => {
        console.log(err)
      })
  }
}

export default actions