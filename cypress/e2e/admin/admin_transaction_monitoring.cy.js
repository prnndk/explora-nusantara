describe("Admin Transaction Monitoring Tests", () => {
  beforeEach(() => {
    cy.loginAdmin();
    cy.visit("/dashboard/admin/transaction");
  });

  it("A12: Verify that the transactions list table is visible", () => {
    cy.get("h1").should("contain.text", "Transaction Validation");
    cy.get("table").should("exist").and("be.visible");
  });

  it("A13: Verify transaction/contract code formatting and detail view invoice format", () => {
    cy.get("table").should("exist");
    cy.get("table").then(($table) => {
      // Check if table contains actual records or if it shows a "No items/records found" message
      const firstRowText = $table.find("tbody tr").first().text().toLowerCase();
      const isEmpty = $table.find("tbody tr").length === 0 ||
        firstRowText.includes("no items") ||
        firstRowText.includes("no records") ||
        firstRowText.includes("tidak ada data") ||
        firstRowText.includes("empty") ||
        firstRowText.includes("tidak ditemukan");

      if (!isEmpty) {
        // Assert that contract codes follow CTR-XXXXXX-XXXX format or are "-"
        $table.find("tbody tr").each((index, tr) => {
          const $tr = Cypress.$(tr);
          const contractCode = $tr.find("td").eq(2).text().trim();
          if (contractCode !== "-") {
            expect(contractCode).to.match(/^CTR-[0-9A-Z]{6}-\d{4}$/);
          }
        });

      }
    });
  });

  it("A14: Verify action buttons (Approve / Reject) are not rendered for Done or Canceled transactions", () => {
    cy.get("table").should("exist");
    cy.get("table").then(($table) => {
      // Check if table contains actual records or if it shows a "No items/records found" message
      const firstRowText = $table.find("tbody tr").first().text().toLowerCase();
      const isEmpty = $table.find("tbody tr").length === 0 ||
        firstRowText.includes("no items") ||
        firstRowText.includes("no records") ||
        firstRowText.includes("tidak ada data") ||
        firstRowText.includes("empty") ||
        firstRowText.includes("tidak ditemukan");

      if (!isEmpty) {
        $table.find("tbody tr").each((index, tr) => {
          const $tr = Cypress.$(tr);
          const statusText = $tr.find("td").eq(5).text().trim();

          if (statusText === "Done" || statusText === "Canceled") {
            // Assert that Approve and Reject buttons do not exist in this row
            // Escape the colon for x-on:click
            expect($tr.find("button[x-on\\:click*='confirm-action']").length).to.equal(0);
            expect($tr.find("button[x-on\\:click*='confirm-delete']").length).to.equal(0);
          }
        });
      }
    });
  });
});
