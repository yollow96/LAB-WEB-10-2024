// Variabel untuk menyimpan jumlah kartu pemain dan dealer
let dealerSum = 0;
let visibleDealerSum = 0;
let playerSum = 0;

// Variabel untuk menghitung jumlah As untuk pemain dan dealer
let dealerAceCount = 0;
let playerAceCount = 0;

// Variabel untuk menyimpan kartu tersembunyi dan dek kartu
let hidden;
let deck;

// Variabel untuk status permainan
let canHit = true;
let gameOver = false;
let playerBalance = 5000; // Saldo awal pemain
let currentBet = 0; // Taruhan saat ini

// Fungsi yang berjalan saat halaman web selesai dimuat
window.onload = function() {
    document.getElementById("place-bet").addEventListener("click", placeBet);
    document.getElementById("hit").addEventListener("click", hit);
    document.getElementById("stay").addEventListener("click", stay);
    document.getElementById("restart").addEventListener("click", restartGame);
    updateBalance();
}

// Fungsi untuk menempatkan taruhan
function placeBet() {
    let betAmount = parseInt(document.getElementById("bet-amount").value);
    // Validasi jumlah taruhan
    if (betAmount < 100 || betAmount > playerBalance) {
        alert("Jumlah taruhan tidak valid. Masukkan nilai antara $100 dan saldo Anda.");
        return;
    }
    currentBet = betAmount;
    playerBalance -= currentBet; // Kurangi saldo pemain
    updateBalance();
    document.getElementById("bet-container").style.display = "none";
    document.getElementById("game-area").style.display = "block";
    startGame(); // Mulai permainan
}

// Fungsi untuk memulai permainan
function startGame() {
    deck = createDeck(); // Buat dek kartu
    shuffleDeck(deck); // Acak dek
    dealerSum = 0;
    visibleDealerSum = 0;
    playerSum = 0;
    dealerAceCount = 0;
    playerAceCount = 0;
    canHit = true;
    gameOver = false;

    document.getElementById("dealer-cards").innerHTML = "";
    document.getElementById("player-cards").innerHTML = "";
    document.getElementById("results").innerText = "";

    // Bagikan kartu awal
    hidden = deck.pop(); // Kartu tersembunyi untuk dealer
    let hiddenImg = document.createElement("img");
    hiddenImg.src = "./cards/BACK.png";
    hiddenImg.id = "hidden-card";
    document.getElementById("dealer-cards").append(hiddenImg);
    dealerSum += getValue(hidden);
    dealerAceCount += checkAce(hidden);

    let visibleCard = deck.pop(); // Kartu terbuka untuk dealer
    addCardToDealer(visibleCard);
    visibleDealerSum += getValue(visibleCard);
    dealerSum += getValue(visibleCard);
    dealerAceCount += checkAce(visibleCard);

    // Bagikan dua kartu untuk pemain
    for (let i = 0; i < 2; i++) {
        let card = deck.pop();
        addCardToPlayer(card);
        playerSum += getValue(card);
        playerAceCount += checkAce(card);
    }

    document.getElementById("hit").disabled = false;
    document.getElementById("stay").disabled = false;

    updateScores(); // Perbarui skor
}

// Fungsi untuk mengambil kartu tambahan
function hit() {
    if (!canHit) return;

    let card = deck.pop();
    addCardToPlayer(card);
    playerSum += getValue(card);
    playerAceCount += checkAce(card);

    // Jika nilai kartu melebihi 21 setelah pengurangan As
    if (reduceAce(playerSum, playerAceCount) > 21) {
        canHit = false;
        document.getElementById("hit").disabled = true;
        stay(); // Paksa stay jika pemain kalah
    }

    updateScores(); // Perbarui skor
}

// Fungsi untuk menyelesaikan giliran pemain
function stay() {
    canHit = false;
    document.getElementById("hit").disabled = true;
    document.getElementById("stay").disabled = true;

    // Tampilkan kartu tersembunyi dealer
    let hiddenImg = document.getElementById("hidden-card");
    hiddenImg.src = "./cards/" + hidden + ".png";

    // Dealer mengambil kartu tambahan
    while (dealerSum < 17) {
        let card = deck.pop();
        addCardToDealer(card);
        dealerSum += getValue(card);
        dealerAceCount += checkAce(card);
    }

    dealerSum = reduceAce(dealerSum, dealerAceCount);
    playerSum = reduceAce(playerSum, playerAceCount);

    gameOver = true;
    updateScores();

    // Menentukan hasil permainan
    let message = "";
    if (playerSum > 21) {
        message = "Anda Kalah!";
    } else if (dealerSum > 21) {
        message = "Anda Menang!";
        playerBalance += currentBet * 2;
    } else if (playerSum == dealerSum) {
        message = "Seri!";
        playerBalance += currentBet;
    } else if (playerSum > dealerSum) {
        message = "Anda Menang!";
        playerBalance += currentBet * 2;
    } else if (playerSum < dealerSum) {
        message = "Anda Kalah!";
    }

    document.getElementById("results").innerText = message;
    updateBalance();

    if (playerBalance <= 0) {
        gameOver = true;
        document.getElementById("game-over").style.display = "flex";
    } else {
        setTimeout(() => {
            document.getElementById("bet-container").style.display = "block";
            document.getElementById("game-area").style.display = "none";
        }, 3000);
    }
}

// Fungsi untuk memperbarui skor di UI
function updateScores() {
    if (gameOver) {
        document.getElementById("dealer-score").innerText = dealerSum;
    } else {
        document.getElementById("dealer-score").innerText = visibleDealerSum;
    }
    document.getElementById("player-score").innerText = reduceAce(playerSum, playerAceCount);
}

// Fungsi untuk membuat dek kartu
function createDeck() {
    let ranks = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
    let suits = ["C", "D", "H", "S"];
    let deck = [];

    for (let i = 0; i < suits.length; i++) {
        for (let j = 0; j < ranks.length; j++) {
            deck.push(ranks[j] + "-" + suits[i]);
        }
    }

    return deck;
}

// Fungsi untuk mengacak dek
function shuffleDeck(deck) {
    for (let i = 0; i < deck.length; i++) {
        let j = Math.floor(Math.random() * deck.length);
        let temp = deck[i];
        deck[i] = deck[j];
        deck[j] = temp;
    }
}

// Fungsi untuk mendapatkan nilai kartu
function getValue(card) {
    let data = card.split("-");
    let value = data[0];

    if (isNaN(value)) {
        if (value == "A") {
            return 11;
        }
        return 10;
    }
    return parseInt(value);
}

// Fungsi untuk memeriksa apakah kartu adalah As
function checkAce(card) {
    if (card[0] == "A") {
        return 1;
    }
    return 0;
}

// Fungsi untuk mengurangi nilai As jika total lebih dari 21
function reduceAce(playerSum, playerAceCount) {
    while (playerSum > 21 && playerAceCount > 0) {
        playerSum -= 10;
        playerAceCount -= 1;
    }
    return playerSum;
}

// Fungsi untuk menambahkan kartu ke pemain
function addCardToPlayer(card) {
    let cardImg = document.createElement("img");
    cardImg.src = "./cards/" + card + ".png";
    document.getElementById("player-cards").append(cardImg);
}

// Fungsi untuk menambahkan kartu ke dealer
function addCardToDealer(card) {
    let cardImg = document.createElement("img");
    cardImg.src = "./cards/" + card + ".png";
    document.getElementById("dealer-cards").append(cardImg);
}

// Fungsi untuk memperbarui saldo pemain di UI
function updateBalance() {
    document.getElementById("balance-amount").innerText = playerBalance;
}

// Fungsi untuk memulai ulang permainan
function restartGame() {
    playerBalance = 5000;
    updateBalance();
    document.getElementById("game-over").style.display = "none";
    document.getElementById("bet-container").style.display = "block";
    document.getElementById("game-area").style.display = "none";
}
