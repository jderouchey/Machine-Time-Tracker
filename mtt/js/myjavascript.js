// Save user data to localStorage
function saveUserData() {
    if (!currentUser) return;
    
    const userData = {
        sessions: sessions,
        shiftStartTime: shiftStartTime
    };
    
    localStorage.setItem('userData_' + currentUser.id, JSON.stringify(userData));
}

// Load user data from localStorage
function loadUserData() {
    if (!currentUser) return;
    
    const savedData = localStorage.getItem('userData_' + currentUser.id);
    if (savedData) {
        const userData = JSON.parse(savedData);
        sessions = userData.sessions || [];
        shiftStartTime = userData.shiftStartTime ? new Date(userData.shiftStartTime) : null;
        
        // Update UI with loaded data
        sessionsCountElement.textContent = sessions.length;
        
        if (shiftStartTime) {
            shiftStartTimeElement.textContent = formatTime(shiftStartTime);
        }
        
        updateDynamicStats();
        refreshSessionList();
    }
}

// Logout functionality
logoutBtn.addEventListener('click', function() {
    localStorage.removeItem('currentUser');
    localStorage.removeItem('userData_' + currentUser.id);
    currentUser = null;
    authContainer.classList.remove('hidden');
    mainContent.classList.add('hidden');
    userInfo.classList.add('hidden');
    
    // Clear form fields
    loginUsername.value = '';
    loginPassword.value = '';
    registerUsername.value = '';
    registerPassword.value = '';
    registerConfirmPassword.value = '';
    registerFullname.value = '';
});

