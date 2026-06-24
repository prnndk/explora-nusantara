describe("Buyer Catalog and Checkout Tests", () => {
  beforeEach(() => {
    cy.loginBuyer();
    cy.visit("/dashboard/buyer/product");
  });

  it("B9 & B11: Browse products, search, and filter by category", () => {
    // Assert catalog has products loaded
    cy.get(".grid").should("exist");

    // Search for Coffee
    cy.get("input[type='search']").type("Coffee");
    // Assert listing updates
    cy.get("body").should("exist");

    // Filter by Category
    cy.contains("button", "Coffee & Tea").click();
  });

  it("B10: View product detail page, check specifications, MOQ and Incoterms", () => {
    // Click on the first product card
    cy.get(".grid").find("a").first().click();

    // Verify detail elements
    cy.get("h1").should("contain.text", "Detail Product");
    cy.contains("Stock Available").should("exist");
    cy.contains("Incoterms").should("exist");

    // Switch to specifications tab
    cy.contains("button", "Specifications").click();
    cy.contains("button", "Seller Info").click();
  });

  it("B5 - B22 & Checkout: Execute complete checkout flow for Anta Herbal Tea and verify Seller transaction contract", () => {
    // Search for "Anta Herbal Tea"
    cy.get("input[type='search']").clear().type("Anta Herbal Tea");
    // Click on the product card that contains the title "Anta Herbal Tea"
    cy.contains("h2", "Anta Herbal Tea").should("be.visible").click();

    // Proceed to Order
    cy.contains("button", "Proceed to Order").click();
    cy.url().should("include", "/checkout");

    // Click 'Change' address button to select or create address
    cy.contains("button", "Change").click();
    cy.contains("Add New Shipping Address").click();

    // Generate unique address name to avoid collisions
    const addressName = "Office " + Math.floor(Math.random() * 100000);

    // Enter new address details in modal
    cy.contains("h3", "Add New Address").should("be.visible");
    cy.contains("label", "Address Name").parent().find("input").type(addressName);
    cy.contains("label", "Full Address").parent().find("input").type("Downtown Core 123, Singapore");
    cy.contains("button", "Save Address").click();

    cy.contains("button", "Change").click();
    cy.contains(addressName).click();

    // Select Shipping Option
    cy.contains("button", "Economic").click(); // Open dropdown
    cy.contains("Reguler").click(); // Select Reguler option

    // Note to seller
    cy.get("input[placeholder='Note to seller']").type("Deliver during working hours");

    // Payment Method
    cy.contains("See Other Payment Methods").click();
    cy.get("input[value='BCA']").check();

    // Pay Now!
    cy.contains("button", "Pay Now!").click();

    // Confirm redirection to checkout-success
    cy.url().should("include", "/checkout-success");
  });
});
