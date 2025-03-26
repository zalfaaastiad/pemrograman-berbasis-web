const kalkulator = (operator, x, y) => {
    switch (operator) {
        case '+':
            return x + y;
        case '-':
            return x - y;
        case '*':
            return x * y;
        case '/':
            return y !== 0 ? x / y : "error: Pembagian dengan nol!";
        case '%':
            return x % y;
        default:
            return "operator tidak valid!";
    }
};

console.log(kalkulator('+', 6, 7)); 
console.log(kalkulator('-', 15, 10));   
console.log(kalkulator('*', 6, 6));   
console.log(kalkulator('/', 20, 10));   
console.log(kalkulator('%', 30, 3));   
console.log(kalkulator('/', 6, 0));   

