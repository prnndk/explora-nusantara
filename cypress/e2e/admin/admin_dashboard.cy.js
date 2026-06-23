describe("Admin Dashboard Summary Tests", () => {
  beforeEach(() => {
    cy.loginAdmin();
    cy.visit("/dashboard/admin");
  });

  it("A15: Verify dashboard displays summary counters and lists", () => {
    // Assert redirect was correct
    cy.url().should("include", "/dashboard/admin");

    // Check presence of widgets or charts
    cy.get("body").should("exist");
    cy.contains("Selamat Datang! Admin").should("exist");
    cy.contains("Unvalidated Products").should("exist");
    cy.contains("Calendar").should("exist");
    cy.contains("Notification").should("exist");
  });
});
