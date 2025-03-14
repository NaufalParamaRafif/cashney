document.addEventListener("alpine:init", () => {
    // Alpine.data("products", () => ({
    //   items: window.products.map(product => {
    //       console.log(product);
    //       console.log('halo');
    //       // return products;
    //   }),
    // }));
  
  Alpine.store("cart", {
    items: [],
    subtotal: 0,
    pajak: 0,
    total: 0,
    quantity: 0,
    add(newItem) {
      const cartItem = this.items.find((item) => item.id === newItem.id);
      if (!cartItem) {
        this.items.push({ ...newItem, quantity: 1, total: newItem.price });
        this.quantity++;
        this.subtotal += Number(newItem.price);
        console.log("new item price:" + newItem.price);
        console.log("subtotal:" + this.subtotal);
      } else {
        this.items = this.items.map((item) => {
          if (item.id !== newItem.id) {
            return item;
          } else {
            item.quantity++;
            item.total = Number(item.quantity * item.price);
            this.quantity++;
            this.subtotal += Number(item.price);
            console.log("item price:" + newItem.price);
            console.log("subtotal:" + this.subtotal);
            return item;
          }
        });
      }
      this.pajak = Number(this.subtotal * 2.5/100);
      console.log("pajak:" + this.pajak);
      this.total = Number(this.subtotal + this.pajak);
      console.log("total:" + this.total);
    },
    remove(id) {
        const cartItem = this.items.find((item) => item.id === id);

        if(cartItem.quantity > 1) {
            this.items = this.items.map((item) => {
                if (item.id !== id){
                    return item
                } else {
                    item.quantity--;
                    item.total = Number(item.quantity * item.price);
                    console.log("harga total:" + item.total);
                    this.quantity--;
                    this.subtotal -= Number(item.price);
                    console.log("subtotal:" + this.subtotal);
                    return item;
                }
            })
        } else if(cartItem.quantity === 1) {
            this.items = this.items.filter((item) => item.id !== id);
            this.quantity--;
            this.subtotal -= Number(cartItem.price);
            console.log("subtotal:" + this.subtotal);
        }
        this.pajak = Number(this.subtotal * 2.5/100);
        console.log("pajak:" + this.pajak);
        this.total = Number(this.subtotal + this.pajak);
        console.log("total:" + this.total);
    }
  });
});

const rupiah = (number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(number);
};