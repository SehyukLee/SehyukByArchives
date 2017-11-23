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
	int shapeStartX;    // 도형의 시작 x점
	int shapeStartY;    // 도형의 시작 y점
	int shapeID;        // 도형 아이디
	
	Shape (int x, int y, int shapeNum) {
		shapeStartX = x;
		shapeStartY = y;
		shapeID 	= shapeNum;
	}
}

class LineShape extends Shape{
	int lineEndX;        // 도형의 끝 x점
	int lineEndY;        // 도형의 끝 y점
	
	LineShape (int startX, int startY, int endX, int endY) {
		super(startX, startY, 1);
		
		lineEndX = endX;
		lineEndY = endY;
	}
}

class RectShape  extends Shape{
	int rectW;            // 도형의 가로 길이
	int rectH;            // 도형의 세로 길이
	
	RectShape (int startX, int startY, int rectWidth, int rectHeight) {
		super(startX, startY, 2);
		
		rectW = rectWidth;
		rectH = rectHeight;
	}
}

class CircShape  extends Shape{
	int circW;             // 도형의 가로 길이
	int circH;             // 도형의 세로 길이
	
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
						// 버튼의 클릭 유무 판별
						
						graph = rightPan.getGraphics();   // 오른 쪽 판넬의 그래픽 객체 가져오기
						
						if (clickedCheck == drawRecBtn) {
							graph.drawRect(e.getX()-(width/2), e.getY()-(height/2), width, height);
							shapeArr.add(new RectShape(e.getX()-(width/2), e.getY()-(height/2), width, height));
						}
						else if (clickedCheck == drawCirBtn) {
							graph.drawOval(e.getX()-(width/2), e.getY()-(height/2), width, height);
							shapeArr.add(new CircShape(e.getX()-(width/2), e.getY()-(height/2), width, height));
						}
						// 클릭 된 버튼에 따라 화면에 도형을 그리고 도형의 정보를 객체에 저장해서 벡터에 추가
						
						else {
							nowXY = e.getPoint();
						}
						// 클린 된 버튼이 선 버튼 일 경우 시작 점을 저장
						
					}
					else {
						JOptionPane.showMessageDialog(rightPan, "도형 버튼을 클릭하십시오.");
					}
					// 버튼이 클릭되지 않았을 경우 경고창 출력
				}
				
				public void mouseReleased(MouseEvent e) {
					super.mouseReleased(e);
					
					if (clickedCheck == drawLineBtn) {
						graph = rightPan.getGraphics();
						graph.drawLine(nowXY.x, nowXY.y, e.getX(), e.getY());	
						shapeArr.add(new LineShape(nowXY.x, nowXY.y, e.getX(), e.getY()));
					}
					// 클릭 된 버튼이 선 버튼 일 경우 선 생성 및 객체에 정보를 저장 후 벡터에 추가
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
		// 벡터에 저장된 객체들의 정보에 따라서 지워진 도형들을 다시 그리기
	}
	
	private drawAct 	rightPan;				// 오른쪽 판넬
	private JPanel 		leftPan;				// 왼쪽 판넬
	private JButton 	drawLineBtn;			// 선 버튼
	private JButton 	drawRecBtn;				// 사각형 버튼
	private JButton 	drawCirBtn;				// 원 버튼
	private JButton 	clickedCheck;			// 클릭된 버튼
	private Graphics 	graph;					// 생성한 도형
	private Point 		nowXY;					// 선의 시작점 지점
	
	final int width  = 50;						// 도형의 가로 길이
	final int height = 50;						// 도형의 세로 길이
	
	Vector<Shape> shapeArr = new Vector();		// 생성한 도형들의 정보를 담은 객체를 넣을 배열
	
	drawFrame () {
		// <------- 프레임의 기본 설정 ---------->
		this.setTitle("세혁이의 그림판");
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		this.setSize(500, 500);
		this.setVisible(true);
		this.setLayout(new BorderLayout());
		// <------- 프레임의 기본 설정 ---------->
		
		rightPan 	= new drawAct();
		leftPan 	= new JPanel();
		// 판넬 생성
		
		leftPan.setLayout(new GridLayout(3, 0));
		// 왼쪽 판넬의 배치 설정
		
		this.add(rightPan, BorderLayout.CENTER);
		this.add(leftPan, BorderLayout.WEST);
		// 프레임에 판넬들 추가
		
		drawLineBtn	 = new JButton("선 그리기");
		drawRecBtn	 = new JButton("사각형 그리기");
		drawCirBtn	 = new JButton("원 그리기");
		// 버튼들 생성
		
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
				// 클릭 된 버튼의 배경 색 변경 및 클릭된 버튼 저장
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
				// 클릭 된 버튼의 배경 색 변경 및 클릭된 버튼 저장
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
				// 클릭 된 버튼의 배경 색 변경 및 클릭된 버튼 저장
			}
		});
		
		leftPan.add(drawLineBtn);
		leftPan.add(drawRecBtn);
		leftPan.add(drawCirBtn);
		// 왼쪽 판넬에 버튼들 추가
	}
}

public class drawTesting {
	public static void main(String[] args) {
		new drawFrame();
		// 프레임 생성
	}
}