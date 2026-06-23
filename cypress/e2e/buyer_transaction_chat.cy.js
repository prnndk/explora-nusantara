describe("Buyer Transaction Live Chat Tests", () => {
  it("B12 & B13 & B14 & B15: View transaction details and verify live chat", () => {
    cy.loginBuyer();
    cy.visit("/dashboard/buyer/transaction");
    cy.get("table").should("exist");
    cy.get("table").contains("tr", "Done").find("a").first().click();

    // Verify detail page elements
    cy.get("h6").should("contain.text", "Product Detail");
    cy.get("h6").should("contain.text", "Seller Detail");
    cy.get("h6").should("contain.text", "Transaction Detail");

    // The chat button "Mulai Percakapan" must be visible now that transaction is Done
    cy.contains("button", "Mulai Percakapan").should("be.visible").click();

    // Verify slideover opens
    cy.get("#slide-over-title").should("exist");

    // B12: Type message in chat textarea
    cy.get("#send-message").type("Hello, interested in your product.");
    cy.get("#send-message").closest("form").find("button[type='submit']").first().click();

    // Check message appears in chat
    cy.contains("Hello, interested in your product.").should("exist");

    // Close the chat slideover
    cy.contains("button", "Close").click();
  });
});
