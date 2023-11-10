
const characterContainer = document.getElementById('character-container');
const searchBar = document.getElementById('search');
const searchBtn = document.getElementById('search-btn');
const modal = document.getElementById('characterModal');
const modalTitle = document.getElementById('modalTitle');
const modalImage = document.getElementById('modalImage');
const modalContent = document.getElementById('modalContent');
const closeModalBtn = document.getElementById('closeModalBtn');
const saveCharacterBtn = document.getElementById('saveCharacterBtn');

closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

searchBtn.addEventListener('click', () => {
    searchBtn.disabled = true;
    const searchValue = searchBar.value;
    if(searchValue){
        getCharacters(searchValue);
    }
    searchBtn.disabled = false;
});

searchBar.addEventListener('keyup', (e) => {
    if(e.key === 'Enter' ){
        const searchValue = searchBar.value;
        if(searchValue){
            getCharacters(searchValue);
        }
    }
});

function getCharacters(searchVal){
    axios({
        url: 'https://rickandmortyapi.com/api/location/'+searchVal,
        method: 'GET',
    }).then(res => {
        const characters = res.data.residents;
        let count = 0;
        for(let i = 0; i < 5 && i < characters.length; i++){
            let id = characters[i].split('/').pop();
            printCharacter(id,res.data.id);
            count++;
        }
        if(characters.length === 0){
            console.log(characters.length === 0)
            characterContainer.innerHTML = '';
            alertify.error(`No se encontraron residentes en la ubicacion "${res.data.name}"`);
        }
    }).catch(err => {
        alertify.error('No se encontraron resultados');
    })

}

function printCharacter(character,location){
    characterContainer.innerHTML = '';
    const characterID = character;
    axios({
        url: 'https://rickandmortyapi.com/api/character/'+character,
        method: 'GET',
    }).then(res => {
        const character = res.data;
        const card = document.createElement('div');
        let bg =location <= 50 ? 'bg-green-500' :
            location <= 80 ? 'bg-blue-500' :
                location > 80 ? 'bg-red-500' : 'bg-white'
        card.className = 'p-4 shadow-md rounded-md '+bg;
        const imageUrl = character.image; // Asegúrate de ajustar según la estructura de datos de la API


        card.innerHTML = `
                    <img src="${imageUrl}" onclick="showModal(${characterID},${location})" alt="Rick & Morty Character" class="w-full h-auto rounded-t-md cursor-pointer show-character">
                    <div class="p-4 flex justify-center">
                        <button class="mx-auto top-0 right-0 p-2 text-white bg-green-800 hover:bg-red-800 rounded-full focus:outline-none focus:shadow-outline-red"
                                onclick="saveCharacter(${characterID},${location})">
                            Guardar
                        </button>
                    </div>
                `;

        characterContainer.appendChild(card);

    }).catch(err => {
        alertify.error('No se encontraron resultados');
    })
}

function saveCharacter(id,location){
    axios({
        url: '/saveCharacter',
        method: 'POST',
        data: {
            id: id,
            location: location
        }
    }).then(res => {
        console.log(res.data);
        alertify.success(res.data.message);
    }).catch(err => {
        console.log(err.response.data.message);
        alertify.error(err.response.data.message);
    })
}

function showModal(id,location){
    if(id){
        axios({
            url: 'https://rickandmortyapi.com/api/character/'+id,
            method: 'GET',
        }).then(res => {
            let respuesta = res.data;
            modalTitle.innerHTML = respuesta.name;
            modalImage.src = respuesta.image;
            let episodes = [];
            respuesta.episode.map(episodeId =>{
                episodeId = episodeId.split('/').pop();
                episodes.push(episodeId);
            })

            let htmlInfo =`
                        <ul>
                            <li>Name: ${respuesta.name}</li>
                            <li>Status: ${respuesta.status}</li>
                            <li>Species: ${respuesta.species}</li>
                            <li>Origin Name: ${respuesta.origin.name}</li>
                            <li>Episodes:</li>
                            </ul>
                    `;

            Promise.all(episodes.map(episodeId =>
                axios({
                    url: 'https://rickandmortyapi.com/api/episode/'+episodeId,
                    method: 'GET',
                }).then(res => {
                    return res.data;
                }).catch(err => {
                    alertify.error('No se encontraron resultados');
                })
            )).then(episodesData => {
                episodesData.sort((a, b) => {
                    let nameA = a.name.toUpperCase();
                    let nameB = b.name.toUpperCase();
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });
                let firstThreeEpisodes = episodesData.slice(0, 3);
                firstThreeEpisodes.forEach(episode => {
                    htmlInfo += `<li class="ml-4"><a  target="_blank" href="${episode.url}">${episode.name}</a></li>`;
                });
                modalContent.innerHTML = htmlInfo;
                // agrega onclick propiedad
                saveCharacterBtn.onclick = () => {
                    saveCharacter(respuesta.id,location);
                }
                modal.classList.remove('hidden');
            });
        }).catch(err => {
            alertify.error('No se encontraron resultados');
        })
    }
}
