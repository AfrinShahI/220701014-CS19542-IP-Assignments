/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/Servlet.java to edit this template
 */

import java.io.*;
import java.sql.*;
import jakarta.servlet.*;
import jakarta.servlet.http.*;

/**
 *
 * @author AFRIN
 */

public class DeleteProductServlet extends HttpServlet {

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html");
        response.setCharacterEncoding("UTF-8");
        PrintWriter out = response.getWriter();
        
        int productId = Integer.parseInt(request.getParameter("id"));

        try {
            // Connect to the database
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/product_management", "root", "afrinshah");

            // Delete the product
            String query = "DELETE FROM products WHERE id = ?";
            PreparedStatement ps = conn.prepareStatement(query);
            ps.setInt(1, productId);

            int rowsDeleted = ps.executeUpdate();

            // Redirect to the view products page after deletion
            if (rowsDeleted > 0) {
                response.sendRedirect("ViewProductsServlet");
            } else {
                out.println("<h2>Error deleting product.</h2>");
            }

            // Close connections
            ps.close();
            conn.close();
        } catch (Exception e) {
            out.println("<h2>Error deleting product.</h2>");
        }
    }
}
