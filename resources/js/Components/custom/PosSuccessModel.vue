<template>
    <TransitionRoot as="template" :show="open" static>
        <Dialog class="relative z-10" static>
            <!-- Modal Overlay -->
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click.stop />
            </TransitionChild>

            <!-- Modal Content -->
            <div class="fixed inset-0 z-10 flex items-center justify-center">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel
                        class="bg-white border-4 border-blue-600 rounded-[20px] shadow-xl max-w-xl w-full p-6 text-center">
                        <!-- Modal Title -->
                        <DialogTitle class="text-5xl font-bold">Payment Successful!</DialogTitle>

                        <div class="w-full h-full flex flex-col justify-center items-center space-y-8 mt-4">
                            <p class="text-justify text-3xl text-black">
                                Order Payment is Successful!
                            </p>
                            <div>
                                <img src="/images/checked.png" class="h-24 object-cover w-full" />
                            </div>
                        </div>
                        <div class="flex justify-center items-center space-x-4 pt-4 mt-4">
                            <p
                                class="cursor-pointer bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl   py-4 rounded-xl">
                                Send Reciept To Email
                            </p>
                            <p @click="handlePrintReceipt"
                                class="cursor-pointer bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl   py-4 rounded-xl">
                                Print Receipt
                            </p>
                            <p @click="$emit('update:open', false)"
                                class="cursor-pointer bg-red-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl   py-4 rounded-xl">
                                Close
                            </p>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { computed } from "vue";
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const page = usePage();

// Access the companyInfo from the page props
const companyInfo = computed(() => page.props.companyInfo);

if (companyInfo.value) {
    console.log(companyInfo.value);
} else {
    console.log('companyInfo is undefined or null');
}

const handleClose = () => {
    console.log("Modal close prevented");
};

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
const props = defineProps({
    open: {
        type: Boolean,
        required: true,
    },
    products: {
        type: Array,
        required: true,
    },
    returnItems: {
        type: Array,
        required: false,
        default: () => [],
    },
    cashier: Object,
    customer: Object,
    orderid: String,
    balance: Number,
    cash: Number,
    subTotal: String,
    totalDiscount: String,
    total: String,
    custom_discount: Number,
    custom_discount_type: String
});

const handlePrintReceipt = () => {
    // Calculate totals from props.products
    const subTotal = props.products.reduce(
        (sum, product) =>
            sum + parseFloat(product.selling_price) * product.quantity,
        0
    );
    const customDiscount = Number(props.custom_discount || 0);
    const totalDiscount = props.products
        .reduce((total, item) => {
            // Check if item has a discount
            if (item.discount && item.discount > 0 && item.apply_discount == true) {
                const discountAmount =
                    (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
                    item.quantity;
                return total + discountAmount;
            }
            return total; // If no discount, return total as-is
        }, 0)
        .toFixed(2); // Ensures two decimal places

    const discount = 0; // Example discount (can be dynamic)
    const total = subTotal - totalDiscount - customDiscount;

    // Generate table rows dynamically using props.products
    const productRows = props.products
        .map((product) => {
            // Determine the price based on discount
            const price = product.discount > 0 && product.apply_discount
                ? product.discounted_price  // Use discounted price if discount is applied
                : product.selling_price;    // Use selling price if no discount

            return `
        <tr>
          <td>${product.name}</td>
          <td style="text-align: center;">${product.quantity}</td>
          <td>
            ${product.discount > 0 && product.apply_discount
                    ? `<div style="font-weight: bold; font-size: 7px; background-color:black; color:white;text-align:center;">${product.discount}% off</div>`
                    : ""
                }
            <div>${product.selling_price}</div>
          </td>
        </tr>
      `;
        })
        .join("");


    // Generate the receipt HTML
    const receiptHTML = `
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Receipt</title>
      <style>
          @media print {
              body {
                  margin: 0;
                  padding: 0;
                  -webkit-print-color-adjust: exact;
              }
          }
          body {
              background-color: #ffffff;
              font-size: 12px;
              font-family: 'Arial', sans-serif;
              margin: 0;
              padding: 10px;
              color: #000;
          }
          .header {
              text-align: center;
              margin-bottom: 16px;
          }
          .header h1 {
              font-size: 20px;
              font-weight: bold;
              margin: 0;
          }
          .header p {
              font-size: 10px;
              margin: 4px 0;
          }
          .section {
              margin-bottom: 16px;
              padding-top: 8px;
              border-top: 1px solid #000;
          }
          .info-row {
              display: flex;
              justify-content: space-between;
              font-size: 12px;
              margin-top: 8px;
          }
          .info-row p {
              margin: 0;
              font-weight: bold;
          }
          .info-row small {
              font-weight: normal;
          }
          table {
              width: 100%;
              font-size: 10px;
              border-collapse: collapse;
              margin-top: 8px;
          }
          table th, table td {
              padding: 6px 8px;

          }
          table th {
              text-align: left;
          }
          table td {
              text-align: right;
          }
          table td:first-child {
              text-align: left;
          }
          .totals {
              border-top: 1px solid #000;
              padding-top: 8px;
              font-size: 12px;
          }
          .totals div {
              display: flex;
              justify-content: space-between;
              margin-bottom: 8px;
          }
          .totals div:nth-child(4) {
              font-size: 14px;
              font-weight: bold;
          }
          .footer {
              text-align: center;
              font-size: 10px;
              margin-top: 16px;
          }
          .footer p {
              margin: 6px 0;
          }
          .footer .italic {
              font-style: italic;
          }


      </style>
  </head>
 <body>
  <div class="receipt-container">
    <!-- Header -->
    <div class="header" style="text-align:center;">
      <img src="/images/billlogo.png" style="width: 150px; height: 140px;" />
      ${companyInfo?.value?.name ? `<h1>${companyInfo.value.name}</h1>` : ''}
      ${companyInfo?.value?.address ? `<p>${companyInfo.value.address}</p>` : ''}
      ${(companyInfo?.value?.phone || companyInfo?.value?.phone2 || companyInfo?.value?.email)
        ? `<p>${companyInfo.value.phone || ''} | ${companyInfo.value.phone2 || ''} ${companyInfo.value.email || ''}</p>`
        : ''}
    </div>

    <!-- Order Info -->
    <div class="section">
      <div class="info-row">
        <div>
          <p>Date:</p>
          <small>${new Date().toLocaleDateString()} </small>
        </div>
        <div>
          <p>Order No:</p>
          <small>${props.orderid}</small>
        </div>
      </div>
      <div class="info-row">
        <div>
          <p>Customer:</p>
          <small>${props.customer.name}</small>
        </div>
        <div>
          <p>Cashier:</p>
          <small>${props.cashier.name}</small>
        </div>
      </div>
    </div>

    <!-- Items Table -->
    <div class="section">
     <table style="width:100%; border-collapse: collapse;">


<thead>
  <tr>
    <th style="text-align:left;">Item</th>
    <th style="text-align:center;">Qty × Price</th>
    <th style="text-align:right;">Total</th>
  </tr>
</thead>
<tbody>
  ${props.products.map(item => {
    const originalPrice = Number(item.selling_price) || 0;
    const discountedPrice = item.apply_discount
      ? Number(item.discounted_price)
      : originalPrice;

    return `




 <tr>
                   <td colspan="4"  ">


      <b>${item.name}</b><br>
          <small style="font-size: 12x; font-weight:600;">Selling Price: ${originalPrice.toFixed(2)}  </small>
     ${
  item.discount > 0
    ? `<small
        style="
          background-color: #000;
          color: #fff;
          font-size: 9px;
          font-weight: 600;
          padding: 2px 6px;
          border-radius: 4px;
          margin: 0 8px;
        "
      >
        ${
          item.discount_type === 'percent'
            ? item.discount + '% off'
            : item.discount.toFixed(2) + ' LKR off'
        }
      </small>`
    : ''
}



                       </td>
               </tr>
               <tr style="border-bottom: 1px dashed #000;  font-size: 14px; font-weight:600;">
 <td style="text-align: left;"></td>

                   <td style="text-align: center;">     ${item.quantity} × ${discountedPrice.toFixed(2)}</td>
                   <td style="text-align: right;">    ${(discountedPrice * item.quantity).toFixed(2)}</td>
               </tr>








    `;
  }).join('')}
</tbody>











</table>

    </div>

    <!-- Totals -->
    <div class="totals">
      <div>
        <span>Sub Total</span>
        <span>${(Number(props.subTotal) || 0).toFixed(2)} LKR</span>
      </div>
      <div>
        <span>Discount</span>
        <span>${(Number(props.totalDiscount) || 0).toFixed(2)} LKR</span>
      </div>
      <div>
        <span>Custom Discount</span>
        <span>
          ${(Number(props.custom_discount) || 0).toFixed(2)}
          ${props.custom_discount_type === 'percent' ? '%' :
            props.custom_discount_type === 'fixed' ? 'LKR' : ''}
        </span>
      </div>
      <div>
        <span>Total</span>
        <span>${(Number(props.total) || 0).toFixed(2)} LKR</span>
      </div>
      <div>
        <span>Cash</span>
        <span>${(Number(props.cash) || 0).toFixed(2)} LKR</span>
      </div>
      <div style="font-weight: bold;">
        <span>Balance</span>
        <span>${(Number(props.balance) || 0).toFixed(2)} LKR</span>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer" style="text-align:center; margin-top:10px;">
      <p>THANK YOU COME AGAIN</p>
      <p class="italic">Let the quality define its own standards</p>
      <p style="font-weight: bold;">Powered by JAAN Network Ltd.</p>
      <p>${new Date().toLocaleTimeString()} </p>
    </div>
  </div>
</body>

  </html>
  `;

    // Open a new window
    const printWindow = window.open("", "_blank");
    if (!printWindow) {
        alert("Failed to open print window. Please check your browser settings.");
        return;
    }

    // Write the content to the new window
    printWindow.document.open();
    printWindow.document.write(receiptHTML);
    printWindow.document.close();

    // Wait for the content to load before triggering print
    printWindow.onload = () => {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
};
</script>
