document.addEventListener("alpine:init", () => {
  Alpine.store("cart", {
    items: [],
    subtotal: 0,
    quantity: 0,

    findItem(id) {
      return this.items.find((item) => item.id === id);
    },

    isForEveryone(discount) {
      if (!discount) return false;

      return (
        discount.max_used - discount.used !== 0 &&
        discount.minimum_purchase_price == 0 &&
        discount.minimum_point == 0
      );
    },

    getPriceAfterDiscount(newItem) {
      const discount = newItem.discount;

      if (!discount || !this.isForEveryone(discount)) {
        return newItem.price;
      }

      if (discount.categories == "nominal") {
        return Number(newItem.price - discount.nominal_discount);
      }

      if (discount.categories == "persentase") {
        return Number(newItem.price - (newItem.price * discount.persentase_harga_discount));
      }

      return newItem.price;
    },

    add(newItem) {
      console.log("Add item:", newItem);

      const cartItem = this.findItem(newItem.id);

      if (!cartItem) {
        const finalPrice = this.getPriceAfterDiscount(newItem);
        this.items.push({ ...newItem, quantity: 1, final_price: finalPrice, total: finalPrice });
        this.quantity++;
        this.subtotal += Number(finalPrice);
      } else {
        cartItem.quantity++;
        cartItem.total = Number(cartItem.quantity * cartItem.final_price);
        this.quantity++;
        this.subtotal += Number(cartItem.final_price);
      }

      console.log("Subtotal:", this.subtotal);
    },

    remove(id) {
      const cartItem = this.findItem(id);

      if (!cartItem) {
        console.warn("Item not found in cart!");
        return;
      }

      if (cartItem.quantity > 1) {
        cartItem.quantity--;
        cartItem.total = Number(cartItem.quantity * cartItem.final_price);
        this.quantity--;
        this.subtotal -= Number(cartItem.final_price);
      } else {
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        this.subtotal -= Number(cartItem.final_price);
      }

      console.log("Subtotal:", this.subtotal);
    },

    clear() {
      this.items = [];
      this.quantity = 0;
      this.subtotal = 0;
    }
  });
});

// helper format rupiah
const rupiah = (number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(number);
};
