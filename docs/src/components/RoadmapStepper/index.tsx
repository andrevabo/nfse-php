import React from "react";
import clsx from "clsx";
import styles from "./styles.module.css";

interface Step {
    title: string;
    description: string;
    status: "completed" | "in-progress" | "pending";
}

const steps: Step[] = [
    {
        title: "Fase 1: Estrutura de Dados (DTOs)",
        description:
            "Implementação de DTOs tipados, mapeamento de campos e validações robustas.",
        status: "completed",
    },
    {
        title: "Fase 2: Serialização",
        description:
            "Geração de XML (padrão Nacional) e JSON a partir dos modelos de dados.",
        status: "in-progress",
    },
    {
        title: "Fase 3: Assinatura Digital",
        description:
            "Suporte a certificados A1 e assinatura digital de documentos XML.",
        status: "pending",
    },
    {
        title: "Fase 4: Utilitários",
        description:
            "Helpers para cálculos de impostos e formatadores de documentos.",
        status: "pending",
    },
];

export default function RoadmapStepper(): React.JSX.Element {
    return (
        <section className={styles.roadmapSection}>
            <div className="container">
                <h2 className={styles.roadmapTitle}>
                    Roadmap de Desenvolvimento
                </h2>
                <div className={styles.stepper}>
                    {steps.map((step, idx) => (
                        <div
                            key={idx}
                            className={clsx(styles.step, styles[step.status])}
                        >
                            <div className={styles.stepMarker}>
                                <div className={styles.stepCircle}>
                                    {step.status === "completed" && (
                                        <span className={styles.checkIcon}>
                                            ✓
                                        </span>
                                    )}
                                    {step.status === "in-progress" && (
                                        <div className={styles.pulse}></div>
                                    )}
                                </div>
                                {idx < steps.length - 1 && (
                                    <div className={styles.stepLine}></div>
                                )}
                            </div>
                            <div className={styles.stepContent}>
                                <h3 className={styles.stepTitle}>
                                    {step.title}
                                </h3>
                                <p className={styles.stepDescription}>
                                    {step.description}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
