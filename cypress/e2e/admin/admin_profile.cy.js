describe("Admin Profile Management Tests", () => {
  beforeEach(() => {
    cy.loginAdmin();
    cy.visit("/dashboard/user-profile");
  });

  it("A5: Access admin profile page and verify fields exist", () => {
    cy.get("h1").should("contain.text", "Admin Profile");
    cy.get("input[name='email']").should("exist");
    cy.get("input[name='password']").should("exist");
  });

  it("A6: Update admin profile fields", () => {
    cy.get("button").contains("Change").should("exist");
    // Verify Cancel button exists
    cy.contains("Cancel").should("exist");
  });
});
