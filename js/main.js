const password = document.getElementById('password');
const start = document.getElementById('start');
const passwordMessage = document.getElementById('passwordMessage');
const psw = 'zefyras';
start.addEventListener('click', e => {
	if (password.value.length === 0) {
		e.preventDefault();
		passwordMessage.innerText = 'Please enter a password';
		return;
	}
	if (password.value !== psw) {
		e.preventDefault();
		passwordMessage.innerText = 'Sorry, the password is not correct';
		return;
	}
});
