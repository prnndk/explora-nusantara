describe("Buyer Transaction Contract Approval Flow", () => {
  it("B20: Execute full contract approval lifecycle (Buyer approve, Admin approve)", () => {
    // 1. Buyer Approves Contract
    cy.loginBuyer();
    cy.visit("/dashboard/buyer/transaction");
    cy.get("body").then(($body) => {
      if ($body.text().includes("Anta Herbal Tea")) {
        cy.contains("table tbody tr", "Anta Herbal Tea").within(() => {
          cy.get("a[href*='/transaction/']").then(($a) => {
            const url = $a.attr("href");
            cy.visit(url);
          });
        });
      } else {
        cy.get("table").find("tbody tr").first().within(() => {
          cy.get("a[href*='/transaction/']").then(($a) => {
            const url = $a.attr("href");
            cy.visit(url);
          });
        });
      }
    });

    // Verify detail page elements
    cy.get("h6").should("contain.text", "Product Detail");
    cy.get("h6").should("contain.text", "Seller Detail");
    cy.get("h6").should("contain.text", "Transaction Detail");

    // Check contract section - upload contract if button exists (B20)
    cy.get("body").then(($body) => {
      const hasUploadButton = $body.find("button:contains('Upload Contract')").length > 0;
      
      if (hasUploadButton) {
        const fileName = "test_contract.pdf";
        cy.contains("h6", "Contract").next("div").within(() => {
          cy.get("input[name='contract_document']").selectFile("cypress/fixtures/" + fileName, { force: true });
          cy.contains(fileName).should("be.visible");
          cy.contains("button", "Upload Contract").click({ force: true });
        });
        cy.contains("Berhasil").should("be.visible");
      }
    });

    // Approve the contract draft
    cy.get("body").then(($body) => {
      if ($body.text().includes("Approve Contract")) {
        cy.contains("button", "Approve Contract").click();
        cy.contains("Kontrak berhasil di-approve").should("exist");
      }
    });

    // 2. Admin Validates/Approves Contract
    cy.loginAdmin();
    cy.visit("/dashboard/admin/contract");
    cy.get("table").should("exist");
    // Click the first contract details link
    cy.get("table").find("tbody tr").first().find("a[href*='contract']").click();

    // Approve the contract from the admin panel
    cy.contains("button", "Approve").click();
    cy.contains("button:visible", "Yes").click();
    cy.contains("Berhasil").should("exist");
  });
});
