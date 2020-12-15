export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.role === 'admin';
    }

    isUser() {
        return this.user.role === 'user';
    }

    isAdminOrAuthor() {

        if(this.user.role === 'admin' || this.user.role === 'author') {
            return true;
        }
    }

    isUserOrAuthor() {
        if(this.user.role === 'user' || this.user.role === 'author') {
            return true;
        }
    }
}
