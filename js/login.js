const password = document.getElementById('password');
const username = document.getElementById('username');
const login = document.getElementById('login');
const passwordMessage = document.getElementById('passwordMessage');
const fetchUsers = async () => {
	try {
		const res = await fetch('./users.json');
		const data = await res.json();
		return data;
	} catch (err) {
		console.error(err);
	}
};

if (login !== null) {
	fetchUsers().then(users => {
		login.addEventListener('submit', e => {
			let validUser = false;
			for (let user in users) {
				if (user === username.value && users[user] === password.value) {
					validUser = true;
					break;
				}
			}
			if (!validUser) {
				e.preventDefault();
				passwordMessage.innerText = 'Incorrect username or password';
				return;
			}
		});
	});
}
