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
    quantity: 0,
    add(newItem) {
      console.log(newItem);
      const cartItem = this.items.find((item) => item.id === newItem.id);
      if (!cartItem) {
          let itemDiscount = newItem.discount;
  
          console.log("itemDiscount:", itemDiscount);
  
          let isForEveryone = () => {
              return itemDiscount &&
                  (itemDiscount.max_used - itemDiscount.used !== 0) &&
                  itemDiscount.minimum_purchase_price == 0 &&
                  itemDiscount.minimum_point == 0;
          };
  
          console.log("isForEveryone:", isForEveryone());
  
          let itemPriceAfterDiscount = () => {
              if (!itemDiscount || !isForEveryone()) {
                  return newItem.price;
              }
  
              if (itemDiscount.categories == "nominal") {
                  return newItem.price - itemDiscount.nominal_discount;
              }
  
              if (itemDiscount.categories == "Persentase Harga") {
                  return newItem.price - (newItem.price * itemDiscount.persentase_harga_discount);
              }
  
              return newItem.price;
          };
  
          let final_price = itemPriceAfterDiscount();
  
          console.log("price after discount:", final_price);
  
          this.items.push({ 
              ...newItem, 
              quantity: 1, 
              final_price: final_price, 
              total: final_price 
          });
  
          this.quantity++;
          this.subtotal += Number(final_price);
  
          console.log("new item price:", final_price);
          console.log("subtotal:", this.subtotal);
        }
        else {
          this.items = this.items.map((item) => {
            if (item.id !== newItem.id) {
              return item;
            }

            item.quantity++;
            item.total = Number(item.quantity * item.final_price);
            this.quantity++;
            this.subtotal += Number(item.final_price);

            console.log("item price:", item.final_price);
            console.log("subtotal:", this.subtotal);

            return item;
          });
        }
    },  
    remove(id) {
        const cartItem = this.items.find((item) => item.id === id);

        if(cartItem.quantity > 1) {
            this.items = this.items.map((item) => {
                if (item.id !== id){
                    return item
                } else {
                    item.quantity--;
                    item.total = Number(item.quantity * item.final_price);
                    console.log("harga total:" + item.total);
                    this.quantity--;
                    this.subtotal -= Number(item.final_price);
                    console.log("subtotal:" + this.subtotal);
                    return item;
                }
            })
        } else if(cartItem.quantity === 1) {
            this.items = this.items.filter((item) => item.id !== id);
            this.quantity--;
            this.subtotal -= Number(cartItem.final_price);
            console.log("subtotal:" + this.subtotal);
        }
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