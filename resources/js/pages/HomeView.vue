<template>
    <div class="min-h-screen bg-bg-default">
      <!-- Le Header -->
      <TheHeader 
        :profileImage="profileImage" 
        :bioText="bioText"
      />
      
      <!-- Navigation tabs -->
      <div class="px-4">
        <div class="flex space-x-6 mb-6 overflow-x-auto justify-center" style="scrollbar-width: none;">
          <button 
            v-for="tab in tabs" 
            :key="tab.id"
            class="font-medium py-3 whitespace-nowrap"
            :class="activeTab === tab.id ? 'text-text-default border-b-2 border-blue-500' : 'text-sub-text-lighter'"
            @click="activeTab = tab.id"
          >
            {{ tab.name }}
          </button>
        </div>
        
        <!-- Container pour centrer les cartes avec max-width -->
        <div class="flex justify-center w-full">
          <!-- Liste des livres avec largeur maximale -->
          <div class="space-y-4 pb-6 w-full max-w-3xl">
            <BookCard 
              v-for="book in filteredBooks" 
              :key="book.id" 
              :book="book" 
            />
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import TheHeader from '../components/TheHeader.vue'
  import BookCard from '../components/BookCard.vue'
  
  export default {
    name: 'Home',
    components: {
      TheHeader,
      BookCard
    },
    data() {
      return {
        profileImage: '/images/profile-image.jpg',
        bioText: "Je suis un passionné de littérature française contemporaine, avec un penchant particulier pour les romans d'auteurs comme David Foenkinos et Anna Gavalda.",
        activeTab: 'all',
        tabs: [
          { id: 'all', name: 'All' },
          { id: 'read', name: 'Read' },
          { id: 'to-read', name: 'To-read' },
          { id: 'pending', name: 'Pending' },
        ],
        books: [
          {
            id: 1,
            title: "Un rien peut tout changer",
            author: "James Clear",
            coverUrl: "/images/atomic-habits.png",
            status: "Pending"
          },
          {
            id: 2,
            title: "Protocols",
            author: "Andrew D. Hubermann",
            coverUrl: "/images/protocols.png",
            status: "To-read"
          },
          {
            id: 3,
            title: "L'art subtil de s'en foutre",
            author: "Mark Manson",
            coverUrl: "/images/subtle-art.png",
            status: "To-read"
          },
          {
            id: 4,
            title: "La femme de ménage se marie",
            author: "Freida McFadden",
            coverUrl: "/images/femme-menage.png",
            status: "Read"
          },
          {
            id: 5,
            title: "Les lois de la nature humaine",
            author: "Robert Greene",
            coverUrl: "/images/lois-nature-humaine.png",
            status: "Read"
          }
        ]
      }
    },
    computed: {
      filteredBooks() {
        if (this.activeTab === 'all') {
          return this.books;
        } else {
          const statusMap = {
            'read': 'Read',
            'to-read': 'To-read',
            'pending': 'Pending',
            'colle': 'Colle'
          };
          return this.books.filter(book => book.status === statusMap[this.activeTab]);
        }
      }
    }
  }
  </script>
  
  <style>
  .bg-nav-button-bg {
    background-color: var(--nav-button-bg);
  }
  
  .text-text-default {
    color: var(--text-default);
  }

  .text-sub-text-lighter {
    color: var(--sub-text-lighter);
  }
  </style>