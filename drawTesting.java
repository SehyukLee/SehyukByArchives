package drawTest;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.GridLayout;
import java.awt.Point;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.Vector;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JPanel;

class Shape {
	int shapeStartX;    // ������ ���� x��
	int shapeStartY;    // ������ ���� y��
	int shapeID;        // ���� ���̵�
	
	Shape (int x, int y, int shapeNum) {
		shapeStartX = x;
		shapeStartY = y;
		shapeID 	= shapeNum;
	}
}

class LineShape extends Shape{
	int lineEndX;        // ������ �� x��
	int lineEndY;        // ������ �� y��
	
	LineShape (int startX, int startY, int endX, int endY) {
		super(startX, startY, 1);
		
		lineEndX = endX;
		lineEndY = endY;
	}
}

class RectShape  extends Shape{
	int rectW;            // ������ ���� ����
	int rectH;            // ������ ���� ����
	
	RectShape (int startX, int startY, int rectWidth, int rectHeight) {
		super(startX, startY, 2);
		
		rectW = rectWidth;
		rectH = rectHeight;
	}
}

class CircShape  extends Shape{
	int circW;             // ������ ���� ����
	int circH;             // ������ ���� ����
	
	CircShape (int startX, int startY, int circWidth, int circHeight) {
		super(startX, startY, 3);
		
		circW = circWidth;
		circH = circHeight;
	}
}

class drawFrame extends JFrame{
	
	class drawAct extends JPanel{
		drawAct () {
			this.addMouseListener(new MouseAdapter () {
				
				public void mousePressed(MouseEvent e) {
					super.mousePressed(e);
					
					if (clickedCheck != null) {
						// ��ư�� Ŭ�� ���� �Ǻ�
						
						graph = rightPan.getGraphics();   // ���� �� �ǳ��� �׷��� ��ü ��������
						
						if (clickedCheck == drawRecBtn) {
							graph.drawRect(e.getX()-(width/2), e.getY()-(height/2), width, height);
							shapeArr.add(new RectShape(e.getX()-(width/2), e.getY()-(height/2), width, height));
						}
						else if (clickedCheck == drawCirBtn) {
							graph.drawOval(e.getX()-(width/2), e.getY()-(height/2), width, height);
							shapeArr.add(new CircShape(e.getX()-(width/2), e.getY()-(height/2), width, height));
						}
						// Ŭ�� �� ��ư�� ���� ȭ�鿡 ������ �׸��� ������ ������ ��ü�� �����ؼ� ���Ϳ� �߰�
						
						else {
							nowXY = e.getPoint();
						}
						// Ŭ�� �� ��ư�� �� ��ư �� ��� ���� ���� ����
						
					}
					else {
						JOptionPane.showMessageDialog(rightPan, "���� ��ư�� Ŭ���Ͻʽÿ�.");
					}
					// ��ư�� Ŭ������ �ʾ��� ��� ���â ���
				}
				
				public void mouseReleased(MouseEvent e) {
					super.mouseReleased(e);
					
					if (clickedCheck == drawLineBtn) {
						graph = rightPan.getGraphics();
						graph.drawLine(nowXY.x, nowXY.y, e.getX(), e.getY());	
						shapeArr.add(new LineShape(nowXY.x, nowXY.y, e.getX(), e.getY()));
					}
					// Ŭ�� �� ��ư�� �� ��ư �� ��� �� ���� �� ��ü�� ������ ���� �� ���Ϳ� �߰�
				}
			});
		}
		
		protected void paintComponent(Graphics g) {
			for (int i = 0; i < shapeArr.size(); i++) {	
				if (shapeArr.get(i).shapeID == 1) {
					LineShape rectCircLineShape = (LineShape) shapeArr.get(i);
					g.drawLine(rectCircLineShape.shapeStartX, rectCircLineShape.shapeStartY, rectCircLineShape.lineEndX, rectCircLineShape.lineEndY);
				}
				else if (shapeArr.get(i).shapeID == 2) {
					RectShape rectCircLineShape = (RectShape) shapeArr.get(i);
					g.drawRect(rectCircLineShape.shapeStartX, rectCircLineShape.shapeStartY, rectCircLineShape.rectW, rectCircLineShape.rectH);
				}
				else {
					CircShape rectCircLineShape = (CircShape) shapeArr.get(i);
					g.drawOval(rectCircLineShape.shapeStartX, rectCircLineShape.shapeStartY, rectCircLineShape.circW, rectCircLineShape.circH);
				}
			}
		}
		// ���Ϳ� ����� ��ü���� ������ ���� ������ �������� �ٽ� �׸���
	}
	
	private drawAct 	rightPan;				// ������ �ǳ�
	private JPanel 		leftPan;				// ���� �ǳ�
	private JButton 	drawLineBtn;			// �� ��ư
	private JButton 	drawRecBtn;				// �簢�� ��ư
	private JButton 	drawCirBtn;				// �� ��ư
	private JButton 	clickedCheck;			// Ŭ���� ��ư
	private Graphics 	graph;					// ������ ����
	private Point 		nowXY;					// ���� ������ ����
	
	final int width  = 50;						// ������ ���� ����
	final int height = 50;						// ������ ���� ����
	
	Vector<Shape> shapeArr = new Vector();		// ������ �������� ������ ���� ��ü�� ���� �迭
	
	drawFrame () {
		// <------- �������� �⺻ ���� ---------->
		this.setTitle("�������� �׸���");
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		this.setSize(500, 500);
		this.setVisible(true);
		this.setLayout(new BorderLayout());
		// <------- �������� �⺻ ���� ---------->
		
		rightPan 	= new drawAct();
		leftPan 	= new JPanel();
		// �ǳ� ����
		
		leftPan.setLayout(new GridLayout(3, 0));
		// ���� �ǳ��� ��ġ ����
		
		this.add(rightPan, BorderLayout.CENTER);
		this.add(leftPan, BorderLayout.WEST);
		// �����ӿ� �ǳڵ� �߰�
		
		drawLineBtn	 = new JButton("�� �׸���");
		drawRecBtn	 = new JButton("�簢�� �׸���");
		drawCirBtn	 = new JButton("�� �׸���");
		// ��ư�� ����
		
		drawLineBtn.addMouseListener(new MouseAdapter() {
			public void mouseClicked(MouseEvent e) {
				super.mouseClicked(e);
				
				if (e.getSource() != clickedCheck) {
					drawLineBtn.setBackground(Color.YELLOW);
					
					if(clickedCheck != null) {
						clickedCheck.setBackground(null);
					}
					
					clickedCheck = (JButton)e.getSource();
				}
				// Ŭ�� �� ��ư�� ��� �� ���� �� Ŭ���� ��ư ����
			}
		});
		
		drawRecBtn.addMouseListener(new MouseAdapter() {
			public void mouseClicked(MouseEvent e) {
				super.mouseClicked(e);
				
				if (e.getSource() != clickedCheck) {
					drawRecBtn.setBackground(Color.YELLOW);
					
					if(clickedCheck != null) {
						clickedCheck.setBackground(null);
					}
					
					clickedCheck = (JButton)e.getSource();
				}
				// Ŭ�� �� ��ư�� ��� �� ���� �� Ŭ���� ��ư ����
			}
		});
		
		drawCirBtn.addMouseListener(new MouseAdapter() {
			public void mouseClicked(MouseEvent e) {
				super.mouseClicked(e);
				
				if (e.getSource() != clickedCheck) {
					drawCirBtn.setBackground(Color.YELLOW);
					
					if(clickedCheck != null) {
						clickedCheck.setBackground(null);
					}
					
					clickedCheck = (JButton)e.getSource();
				}
				// Ŭ�� �� ��ư�� ��� �� ���� �� Ŭ���� ��ư ����
			}
		});
		
		leftPan.add(drawLineBtn);
		leftPan.add(drawRecBtn);
		leftPan.add(drawCirBtn);
		// ���� �ǳڿ� ��ư�� �߰�
	}
}

public class drawTesting {
	public static void main(String[] args) {
		new drawFrame();
		// ������ ����
	}
}