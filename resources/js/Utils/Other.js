export const generateOrderId = () => {
    const prefix = "CH";

    // Get today's date in DD.MM.YY format
    const today = new Date();
    const day = String(today.getDate()).padStart(2, "0");
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const year = String(today.getFullYear()).slice(-2); // Last two digits of the year
    const formattedDate = `${year}.${month}.${day}`;

    // Retrieve the last order ID and date from localStorage
    const lastOrderId = localStorage.getItem("lastOrderId");
    const lastDate = localStorage.getItem("lastOrderDate");

    let count = 1; // Start with 1 by default

    if (lastDate === formattedDate && lastOrderId) {
        // If the stored date matches today, increment the count
        count = parseInt(lastOrderId, 10) + 1;
    }

    // Format the count with leading zeros (e.g., "0001")
    const formattedCount = String(count).padStart(4, "0");

    // Save the new count and date in localStorage
    localStorage.setItem("lastOrderId", count);
    localStorage.setItem("lastOrderDate", formattedDate);

    // Return the generated order ID
    return `${prefix}/${formattedDate}/${formattedCount}`;
};
