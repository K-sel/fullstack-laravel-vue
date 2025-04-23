<template>
    <header class="px-4 py-6 bg-bg-default">
      <!-- Top navigation row with icons -->
      <div class="flex justify-between items-center mb-6">
        <button class="w-8 h-8 flex items-center justify-center rounded-full bg-nav-button-bg">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-text-default">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
        </button>
        
        <div class="flex items-center gap-3">
          <!-- Dark Mode Toggle -->
          <div class="flex items-center gap-2">
            <span class="text-xs text-text-default">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
              </svg>
            </span>
            <button 
              @click="toggleDarkMode" 
              class="w-10 h-5 rounded-full flex items-center px-0.5 transition-colors duration-200"
              :class="isDarkMode ? 'bg-blue-600 justify-end' : 'bg-gray-300 justify-start'"
              aria-label="Changer de thème"
            >
              <span class="w-4 h-4 rounded-full bg-white shadow-md block transition-transform duration-200"></span>
            </button>
            <span class="text-xs text-text-default">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
              </svg>
            </span>
          </div>
          
          <!-- Menu Button -->
          <button class="w-8 h-8 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-text-default">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>
      
      <!-- Profile section -->
      <div class="flex flex-col items-center mb-6">
        <!-- Profile picture -->
        <div class="w-24 h-24 rounded-full overflow-hidden mb-6 shadow-md">
          <img :src="profileImage" alt="Profile" class="w-full h-full object-cover" />
        </div>
        
        <!-- Bio text -->
        <p class="text-text-default text-center max-w-xs mb-4">
          {{ bioText }}
        </p>
        
        <!-- Logout Button -->
        <button 
          @click="logout" 
          class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors duration-200 flex items-center gap-2"
          :class="isDarkMode ? 'bg-gray-800 text-white hover:bg-gray-700' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
          aria-label="Se déconnecter"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Déconnexion
        </button>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    name: 'TheHeader',
    props: {
      profileImage: {
        type: String,
        required: true
      },
      bioText: {
        type: String,
        required: true,
        default: "Je suis un passionné de littérature française contemporaine, avec un penchant particulier pour les romans d'auteurs comme David Foenkinos et Anna Gavalda."
      }
    },
    data() {
      return {
        isDarkMode: false
      }
    },
    created() {
      // Check if dark mode is already enabled (either by system preference or user choice)
      this.isDarkMode = this.checkDarkMode();
      
      // Initialize theme
      this.applyTheme();
    },
    methods: {
      toggleDarkMode() {
        this.isDarkMode = !this.isDarkMode;
        this.applyTheme();
        
        // Save user preference
        localStorage.setItem('darkMode', this.isDarkMode ? 'enabled' : 'disabled');
      },
      
      applyTheme() {
        // Apply dark mode class to document
        if (this.isDarkMode) {
          document.documentElement.classList.add('dark-mode');
          document.documentElement.setAttribute('data-theme', 'dark');
        } else {
          document.documentElement.classList.remove('dark-mode');
          document.documentElement.setAttribute('data-theme', 'light');
        }
      },
      
      checkDarkMode() {
        // Check saved preference
        const savedPreference = localStorage.getItem('darkMode');
        if (savedPreference) {
          return savedPreference === 'enabled';
        }
        
        // Check system preference
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      },
      
      logout() {
        // Handle logout action
        alert('Déconnexion en cours...');
        // In a real app, you would do something like:
        // this.$store.dispatch('auth/logout');
        // this.$router.push('/login');
      }
    }
  }
  </script>
  
  <style scoped>
  .bg-nav-button-bg {
    background-color: var(--nav-button-bg);
  }
  
  .text-text-default {
    color: var(--text-default);
  }
  </style>