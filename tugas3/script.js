function fibonacci(n){
    let deretfibonacci = [0,1];

    for (let i=2; i < n; i++){
        deretfibonacci[i] = deretfibonacci[i-1] + deretfibonacci[i-2];

    }
    return deretfibonacci;
}

let n = 16;
console.log("deret fibonacci dengan" + n + "angka: ", fibonacci(n));