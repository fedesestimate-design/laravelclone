function kStart(k, n) {
    let arr = [];
    let count = 1;
    while(count <= n){
        arr.push(k);
        k++;
        count++;
    }
    console.log(arr);
    return arr;
}

kStart(3,5)