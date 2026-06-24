describe("Seller Transaction Contract Flow", () => {
  it("S20: Upload or edit contract document as Seller", () => {
    cy.loginSeller();
    cy.visit("/dashboard/seller/transaction");
    cy.get("table").should("exist");
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

    // Check contract section
    cy.get("body").then(($body) => {
      const hasUploadButton = $body.find("button:contains('Upload Contract')").length > 0;
      
      if (hasUploadButton) {
        const fileName = "signed_contract.pdf";
        cy.contains("h6", "Contract").next("div").within(() => {
          cy.get("input[name='contract_document']").selectFile("cypress/fixtures/" + fileName, { force: true });
          cy.contains(fileName).should("be.visible");
          cy.contains("button", "Upload Contract").click({ force: true });
        });
        cy.contains("Berhasil").should("be.visible");
      } else if ($body.find("span:contains('New Request')").length > 0) {
        // Open the dropdown first
        cy.contains("p", "File:").next("div").find("button").first().click({ force: true });
        cy.contains("button", "Edit File").click({ force: true });
        const fileName = "signed_contract_rev.pdf";
        // Wait for modal to be visible and scope actions inside it
        cy.contains("h3", "Update Contract File").should("be.visible");
        cy.contains("h3", "Update Contract File").parents("div.relative").first().within(() => {
          cy.get("input[name='contract_document']").selectFile("cypress/fixtures/" + fileName, { force: true });
          cy.contains(fileName).should("be.visible");
          cy.contains("button", "Update Contract File").click({ force: true });
        });
        cy.contains("Berhasil").should("be.visible");
      }
    });
  });
});
