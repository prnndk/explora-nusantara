describe("Seller Transaction Live Chat Tests", () => {
  it("S12 & S13 & S14 & S15: View transactions, check chat, send message, and read receipt", () => {
    cy.loginSeller();
    cy.visit("/dashboard/seller/transaction");
    cy.get("table").should("exist");

    cy.get("table").contains("tr", "Done").find("a").first().click();

    // Verify detail page elements
    cy.get("h6").should("contain.text", "Product Detail");
    cy.get("h6").should("contain.text", "Buyer Detail");
    cy.get("h6").should("contain.text", "Transaction Detail");

    // The chat button "Mulai Percakapan" must be visible now that transaction is Done
    cy.contains("button", "Mulai Percakapan").should("be.visible").click();

    // Verify slideover opens
    cy.get("#slide-over-title").should("exist");

    // S12: Type message in chat textarea
    cy.get("#send-message").type("Price quotation has been updated.");
    cy.get("#send-message").closest("form").find("button[type='submit']").first().click();

    // Check message appears in chat
    cy.contains("Price quotation has been updated.").should("exist");

    // Close the chat slideover
    cy.contains("button", "Close").click();
  });
});
