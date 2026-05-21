const coinsList = document.getElementById('coins-list');
const nftsList = document.getElementById('nfts-list');

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const query = params.get('query');
    if (query) {
        fetchSearchResult(query, ['coins-list', 'nfts-list']);
    } else {
        fetchSearchResult('bit', ['coins-list', 'nfts-list']);
    }
});

function fetchSearchResult(param, idsToToggle) {

    idsToToggle.forEach(id => {
        const errorElement = document.getElementById(`${id}-error`);

        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
        toggleSpinner(id, `${id}-spinner`, true);
    });

    coinsList.innerHTML = '';
    nftsList.innerHTML = '';

    const url = `https://api.coingecko.com/api/v3/search?query=${encodeURIComponent(param)}`;
    const options = { method: 'GET', headers: { accept: 'application/json' } };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            idsToToggle.forEach(id => toggleSpinner(id, `${id}-spinner`, false));
            return response.json();
        })
        .then(data => {
            let coins = (data.coins || []).filter(coin => coin.thumb !== "missing_thumb.png");
            let nfts = (data.nfts || []).filter(nf => nf.thumb !== "missing_thumb.png");

            const coinsCount = coins.length;
            const nftsCount = nfts.length;

            let minCount = Math.min(coinsCount, nftsCount);

            if (coinsCount > 0 && nftsCount > 0) {
                coins = coins.slice(0, minCount);
                nfts = nfts.slice(0, minCount);
            }

            coinsResult(coins);
            nftsResult(nfts);

            if (coins.length === 0) {
                coinsList.innerHTML = '<p style="color: red; text-align: center;">No results found for coins.</p>';
            }

            if (nfts.length === 0) {
                nftsList.innerHTML = '<p style="color: red; text-align: center;">No results found for nfts.</p>';
            }

        })
        .catch(error => {
            idsToToggle.forEach(id => {
                toggleSpinner(id, `${id}-spinner`, false);
                const errorElement = document.getElementById(`${id}-error`);
                if (errorElement) {
                    errorElement.textContent = 'Unable to fetch results. Please try again later.';
                    errorElement.style.display = 'block';
                }
            });
            console.error('Error fetching data:', error);
        });
}

function coinsResult(coins) {
    coinsList.innerHTML = '';

    const table = createTable([
        'Rank', 'Coin'
    ]);

    coins.forEach(coin => {
        const row = document.createElement('tr');
        row.innerHTML = `
           <td>${coin.market_cap_rank}</td>
            <td class="name-column"><img src="${coin.thumb}" alt="${coin.name}"> ${coin.name} <span>(${coin.symbol.toUpperCase()})</span></td>
        `;
        table.appendChild(row);
        row.onclick = () => {
            window.location.href = `coin.html?coin=${coin.id}`;
        };
    });
    coinsList.appendChild(table);
}



function nftsResult(nfts) {
    nftsList.innerHTML = '';

    const table = createTable([
        'NFT', 'Symbol'
    ]);

    nfts.forEach(nf => {
        const row = document.createElement('tr');
        row.innerHTML = `
           <td class="name-column"><img src="${nf.thumb}" alt="${nf.name}"> ${nf.name}</td>
            <td class="name-column">${nf.symbol}</td>
        `;
        table.appendChild(row);

    });
    nftsList.appendChild(table);
}