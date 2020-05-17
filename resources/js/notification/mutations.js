let mutations = {
  GET_NOTIFICATIONS(state, notifications) {
    state.notifications = notifications
  },
  ADD_NOTIFICATION(state, notification) {
    state.notifications = [...state.notifications, notification]
  }
}

export default mutations