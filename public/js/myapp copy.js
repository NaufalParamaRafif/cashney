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
    cashback: 0,
    add(newItem) {
      console.log(newItem);
      const cartItem = this.items.find((item) => item.id === newItem.id);
      if (!cartItem) {
        let itemPriceAfterDiscount = (itemCategory) => {
          if(itemCategory == "nominal"){
            return Number(newItem.price - newItem.discount.nominal_discount);
          } else if(itemCategory == "persentase") {
            return Number(newItem.price - (newItem.price * persentase_harga_discount));
          }
          // else if(itemCategory == "Paket" || itemCategory == "Voucher Pembelian") {
          //   return Number(newItem.price - (newItem.price * persentase_harga_discount));
          // } else if(itemCategory == "Cashback" || itemCategory == "Voucher Pembelian") {
            
          // }
        };
        let price_after_discount = itemPriceAfterDiscount(newItem.discount.categories);
        console.log("price after discount: " + price_after_discount);
        this.items.push({ ...newItem, quantity: 1, price_after_discount: price_after_discount, total: price_after_discount });
        this.quantity++;
        this.subtotal += Number(price_after_discount);
        console.log("new item price:" + price_after_discount);
        console.log("subtotal:" + this.subtotal);
      } else {
        this.items = this.items.map((item) => {
          if (item.id !== newItem.id) {
            return item;
          } else {
            // cek diskon
            item.quantity++;
            item.total = Number(item.quantity * item.price_after_discount);
            this.quantity++;
            this.subtotal += Number(item.price_after_discount);
            console.log("item price:" + newItem.price_after_discount);
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
                    item.total = Number(item.quantity * item.price_after_discount);
                    console.log("harga total:" + item.total);
                    this.quantity--;
                    this.subtotal -= Number(item.price_after_discount);
                    console.log("subtotal:" + this.subtotal);
                    return item;
                }
            })
        } else if(cartItem.quantity === 1) {
            this.items = this.items.filter((item) => item.id !== id);
            this.quantity--;
            this.subtotal -= Number(cartItem.price_after_discount);
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