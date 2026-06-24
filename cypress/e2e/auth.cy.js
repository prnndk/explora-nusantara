describe("Authentication Flow Tests", () => {
  beforeEach(() => {
    cy.visit("/login");
  });

  // Visiblity toggle is shared since it's the exact same login form page for all roles
  it("B3 & S3 & A3: Verify toggle password visibility works", () => {
    // Assert initial type is password
    cy.get("#password").should("have.attr", "type", "password");

    // Click toggle button
    cy.get("button[onclick*='togglePassword']").click();

    // Assert type changed to text
    cy.get("#password").should("have.attr", "type", "text");

    // Click toggle button again
    cy.get("button[onclick*='togglePassword']").click();

    // Assert type changed back to password
    cy.get("#password").should("have.attr", "type", "password");
  });

  // --- Buyer Auth ---
  it("B2: Login buyer with invalid credentials", () => {
    cy.get("#username").type("buyerdemo_salah");
    cy.get("#password").type("WrongPassword123");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/login");
  });

  it("B1 & B4: Login buyer with valid credentials and then Logout", () => {
    cy.get("#username").type("buyerdemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard");

    // B4: Click Logout
    cy.get("form[action*='logout']").submit();
    cy.url().should("include", "/login");
  });

  // --- Seller Auth ---
  it("S2: Login seller with invalid credentials", () => {
    cy.get("#username").type("sellerdemo_salah");
    cy.get("#password").type("WrongPassword123");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/login");
  });

  it("S1 & S4: Login seller with valid credentials and then Logout", () => {
    cy.get("#username").type("sellerdemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard");

    // S4: Click Logout
    cy.get("form[action*='logout']").submit();
    cy.url().should("include", "/login");
  });

  // --- Admin Auth ---
  it("A2: Login admin with invalid credentials", () => {
    cy.get("#username").type("admindemo_salah");
    cy.get("#password").type("WrongPassword123");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/login");
  });

  it("A1 & A4: Login admin with valid credentials and then Logout", () => {
    cy.get("#username").type("admindemo");
    cy.get("#password").type("Password1234#");
    cy.contains("button", "Login").click();
    cy.url().should("include", "/dashboard");

    // A4: Click Logout
    cy.get("form[action*='logout']").submit();
    cy.url().should("include", "/login");
  });
});
