describe("Admin Validation and Monitoring Tests", () => {
  beforeEach(() => {
    cy.loginAdmin();
  });

  it("VP1 & VP2 & VP3: Product validation flow", () => {
    cy.visit("/dashboard/admin/product");
    cy.get("table").should("exist");

    // Click the first product details link
    cy.get("table").find("tbody tr").first().find("a[href*='product']").click();

    // Verify detail view and check multi-photo gallery (A7)
    cy.get("h6").should("contain.text", "Product Detail");
    cy.get("img").should("exist");
    cy.get("body").then(($body) => {
      if ($body.find("div.grid img").length > 0) {
        cy.get("div.grid img").should("be.visible");
      }
    });

    // Try to trigger approve transaction modal
    cy.get("body").then(($body) => {
      if ($body.text().includes("Accept")) {
        cy.contains("button", "Accept").click();
        cy.contains("Are you sure want to approve this product?").should("be.visible");
        cy.contains("button:visible", "No").click(); // close modal
      }
    });
  });

  it("VC1 & VC2 & VC3: Contract validation flow", () => {
    cy.visit("/dashboard/admin/contract");
    cy.get("table").should("exist");

    // Click the first contract details link
    cy.get("table").find("tbody tr").first().find("a[href*='contract']").click();

    // Verify detail tabs (Buyer, Seller, Product, File)
    cy.contains("button", "Buyer").click();
    cy.contains("button", "Seller").click();
    cy.contains("button", "Product").click();
    cy.contains("button", "File").click();

    // A7: Verify open file option in the File tab
    cy.get("div[x-show*='file']").find("button").first().click({ force: true });
    cy.contains("a", "Open File").should("have.attr", "target", "_blank");
    cy.contains("a", "Open File").should("have.attr", "href").and("include", "/view-file/");

    // Try to trigger reject modal
    cy.contains("button:visible", "Reject").click();
    cy.contains("Are you sure want to reject this contract?").should("be.visible");
    cy.contains("button:visible", "No").click(); // close modal
  });

  it("VT1 & VT2 & VT3: Transaction monitoring and validation details", () => {
    cy.visit("/dashboard/admin/transaction");
    cy.get("table").should("exist");

    // Click first transaction details link
    cy.get("table").find("tbody tr").first().find("a[href*='transaction']").click();

    // Verify page details
    cy.get("h6").should("contain.text", "Product Detail");
    cy.get("h6").should("contain.text", "Seller Detail");
    cy.get("h6").should("contain.text", "Buyer Detail");
    cy.get("h6").should("contain.text", "Transaction Detail");
  });
});
